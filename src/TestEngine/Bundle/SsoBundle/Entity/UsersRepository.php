<?php

namespace TestEngine\Bundle\SsoBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

/**
 * UsersRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class UsersRepository extends EntityRepository
{

    const STATUS_OFFLINE          = 'offline';
    const STATUS_ONLINE           = 'online';
    const STATUS_ONBREAK          = 'onbreak';
    const STATUS_NOT_ACTIVE       = 'not-active';
    const STATUS_NOT_USING_CLIENT = 'not-using-client';

    public function getUserInfoByEmailAndPassword($email, $loginPassword)
    {
        $password = md5($loginPassword);

        $dql = "SELECT users FROM TestEngineSsoBundle:Users as users
                            WHERE users.login = '$email'
                              AND users.password ='$password'";

        $result = $this->getEntityManager()
                       ->createQuery($dql)
                       ->setHydrationMode(2) // associative as array
                       ->getOneOrNullResult();

        return $result ? (object)$result : false;
    }

    public function getUserInfoByLogin($email)
    {
        $dql = "SELECT users FROM CoreBundle:Users as users
                            WHERE users.login = '$email'";

        $result = $this->getEntityManager()
            ->createQuery($dql)
            ->setHydrationMode(2) // associative as array
            ->getOneOrNullResult();

        return $result ? (object)$result: '';
    }

    public function getUserInfoById($userId)
    {
        $dql = "SELECT users FROM CoreBundle:Users as users
                            WHERE users.id = '$userId'";

        $result = $this->getEntityManager()
                       ->createQuery($dql)
                       ->setHydrationMode(2) // associative as array
                       ->getOneOrNullResult();

        return $result;
    }

    public function getUserRegDate($userId)
    {
        if (!$userId){
            return false;
        }

        $dql = "SELECT u.id, cr.dateReg, ur.regDate
                        FROM CoreBundle:Users        AS u
                   LEFT JOIN CoreBundle:CompanyRegs  AS cr WITH cr.userId=u.id
                   LEFT JOIN CoreBundle:UsersRegs    AS ur WITH ur.userId=u.id
                       WHERE u.id = $userId";

        $result = $this->getEntityManager()
                       ->createQuery($dql)
                       ->getOneOrNullResult();

        if (empty($result)) {
            return false;
        }

        return !empty($result['dateReg']) ? $result['dateReg'] : $result['regDate'];

    }

    public function getUserLastDesktopLoginTime($userId)
    {
        if (!$userId){
            return false;
        }

        $dql = "SELECT Users.desktopLastLogin FROM CoreBundle:Users as Users WHERE Users.id=$userId";

        $result = $this->getEntityManager()
                       ->createQuery($dql)
                       ->getOneOrNullResult();

        return $result ? $result['desktopLastLogin']->format('Y-m-d H:i:s') : false;
    }

    public function getManagedUsers($userId, $includeSelf = false)
    {
        if (!$userId) {
            return false;
        }

        $dql = "SELECT Users.id, Users.active, Users.name, Users.lastname, Users.avatar
                               FROM CoreBundle:UserRelations as UR
                          LEFT JOIN CoreBundle:Users as Users WITH Users.id = UR.userId
                              WHERE UR.managerId = $userId";

        $result = $this->getEntityManager()
                       ->createQuery($dql)
                       ->execute();

        if ($includeSelf) {
            $result[] = $this->getUserInfo($userId);
        }


        if ($result) {
            $users = array();
            foreach($result as $key => $row) {
                $users[$key] = $row['name'];
            }

            array_multisort($users, SORT_ASC, $result);

            return $result;
        }

        return false;
    }

    public function getUserInfo($userId)
    {
        if (!$userId) {
            return false;
        }

        $dql = "SELECT Users.id, Users.active, Users.name, Users.lastname, Users.avatar
                               FROM CoreBundle:Users as Users
                              WHERE Users.id = $userId";

        $result = $this->getEntityManager()
                       ->createQuery($dql)
                       ->getOneOrNullResult();


        return $result ? $result : false;

    }

    public function getUserStatus($userId, $isActive = false, $timeZone, $userIdentity)
    {

        if (!$isActive) {
            // This user has been invited but has not yet created a password.
            return array(
                'code' => self::STATUS_NOT_ACTIVE,
                'info' => 'Not yet activated'
            );
        }

        $lastActivity = $this->getUserLastActivity($userId, $timeZone);

        if ($lastActivity){
            if ($lastActivity->getWorkMode() == 0 ){

                $task = $this->getRunningTaskName($lastActivity->getTaskId());
                if ($task) {
                    // when user is working we should return task-name
                    return array(
                        'code' => self::STATUS_ONLINE,
                        'info' => $task['taskName']
                    );
                }else{
                    // we have a problem, user is working but we cannot find the task
                    return array(
                        'code' => self::STATUS_ONLINE,
                        'info' => 'Not found!'
                    );
                }
            }else{
                return array(
                    'code' => self::STATUS_ONBREAK,
                    'info' => 'On a break'
                );
            }
        }elseif ($userIdentity->desktopLastLogin->format('Y-m-d H:i:s') > '0000-00-00 00:00:00') {
            // user is offline
            return array('code' => self::STATUS_OFFLINE, 'info' => 'Offline');
        }else {
            // This user has an account with a password, but they have never signed into the TD Desktop app
            // (never - not once in their life).
            return array(
                'code' => self::STATUS_NOT_USING_CLIENT,
                'info' => 'Not using TD Software'
            );
        }
    }

    public function getAvatarHref($userId)
    {
        $avatar = sprintf('/storage/avatars/%d.jpg', $userId);
        $avatarfullpath = '../' . $avatar;

        if (file_exists($avatarfullpath)) {
            return $avatar;
        } else {
            return '/storage/avatars/small_avatar.png';
        }
    }

    protected function getRunningTaskName($taskId)
    {

        $dql = "SELECT T.taskName FROM CoreBundle:Tasks T
                        WHERE T.taskId = :TaskId";

        $result = $this->getEntityManager()
                       ->createQuery($dql)
                       ->setParameter('TaskId', $taskId)
                       ->getOneOrNullResult();

        return $result;
    }

    protected function getUserLastActivity($userId, $timezone)
    {
        $date = new \DateTime(date('Y-m-d H:i:s'), new \DateTimeZone('UTC'));
        $currentTime = $timezone ? $timezone : strtotime($date->format('Y-m-d H:i:s'));


        $sql = 'SELECT WL.* FROM worklog3 AS WL
                           WHERE WL.user_id = '.$userId.'
                             AND UNIX_TIMESTAMP(CONVERT_TZ(NOW(), "UTC",'.$currentTime.')) - UNIX_TIMESTAMP(WL.end_time) < 240
                             AND WL.work_mode <> 6
                             AND (WL.task_id > 0 OR WL.task_id = -2)
                             AND WL.deleted = 0
                             AND WL.edited = 0
                        ORDER BY WL.auto_time DESC';

        $rsm = new ResultSetMapping();
        $record = $this->getEntityManager()->createNativeQuery($sql, $rsm)->getOneOrNullResult();


        return $record;
    }

    public function getUserWeeklyWorkRecordsByUser($userIds, $date)
    {
        $weekStart = $this->getWeekStart($date);
        $weekEnd   = $this->getWeekEnd($date);

        $sql = "SELECT user_id,
                       DATE(start_time) as date,
                       work_mode,
                       SUM((UNIX_TIMESTAMP( end_time ) - UNIX_TIMESTAMP(start_time))) as length
                       FROM worklog3 AS WL
                      WHERE work_mode IN (0,3,6,7)
                        AND WL.user_id IN (". implode(',', $userIds) .")
                        AND WL.start_time >= '". $weekStart ."'
                        AND WL.start_time <= '". $weekEnd ."'
                        AND deleted = 0
                   GROUP BY user_id,date
               ";

        $recordList = $this->getEntityManager()->getConnection()->query($sql)->fetchAll();

        return $recordList;
    }

    public function getUserDailyWorkRecordsByUser($userIds, $date)
    {
        $sql = "SELECT  WL.task_id, WL.user_id, task_name, start_time,
                        (UNIX_TIMESTAMP( WL.end_time ) - UNIX_TIMESTAMP(WL.start_time)) as length,
                        WL.edited,
                        WL.work_mode
                        FROM worklog3 AS WL
                  INNER JOIN tasks    AS T ON WL.task_id = T.task_id
                       WHERE WL.user_id IN (". implode(',', $userIds) .")
                         AND (WL.work_mode NOT IN (4,5))
                         AND WL.start_time >= '". $date ." 00:00:00'
                         AND WL.start_time <= '". $date ." 23:59:59'
                         AND WL.deleted = 0
                    ORDER BY WL.start_time" ;

        $recordList = $this->getEntityManager()->getConnection()->query($sql)->fetchAll();

        return $recordList;
    }


    public function getWeekStart($date){

        $tmStamp = strtotime($date);
        while (date('w', $tmStamp) <> 1) { 	//1 = Monday (0 - Sunday)
            $tmStamp -= 3600 * 24;
        }

        return $this->getDayStart($tmStamp);
    }

    public function getWeekEnd($date) {

        $tmStamp = strtotime($date);
        while (date('w', $tmStamp) <> 0) {
            $tmStamp += 3600 * 24;
        }
        return $this->getDayEnd($tmStamp);
    }

    //get the start day
    public function getDayStart($time) {
        $tmStamp = mktime(0, 0, 0, date('m', $time), date('d', $time), date('Y', $time));
        return date("Y-m-d H:i:s", $tmStamp);	//begin of the day
    }

    //get the end day
    public function getDayEnd($time){
        $tmStamp = mktime(23, 59, 59, date('m', $time), date('d', $time), date('Y', $time));
        return date("Y-m-d H:i:s", $tmStamp);	//begin of the day
    }

    public function getBySSOCode($ssoCode)
    {
        $sql = "SELECT * FROM sso_links WHERE code = '" . $ssoCode . "'";
        $record = $this->getEntityManager()->getConnection()->query($sql)->fetchAll();

        return $record ? $record[0] : '';
    }

    public function insertSsoSessionId($sessionId, $link)
    {
        $sql = "INSERT INTO `sso_links`(`code`, `link`) VALUES('" . $sessionId . "', '" . $link . "')";

        return $this->getEntityManager()->getConnection()->query($sql);
    }

    public function updateSsoSessionId($sessionId, $link)
    {
        $sql = "UPDATE `sso_links` SET `link` = '" . $link . "' WHERE `code` = '" . $sessionId . "'";

        return $this->getEntityManager()->getConnection()->query($sql);
    }

    public function removeSSOLinks()
    {
        $sql = "TRUNCATE sso_links";
        return $this->getEntityManager()->getConnection()->query($sql);
    }
}
