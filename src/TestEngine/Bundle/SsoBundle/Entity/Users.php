<?php

namespace TestEngine\Bundle\SsoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="TestEngine\Bundle\SsoBundle\Entity\UsersRepository")
 */
class Users
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="login", type="string", length=100, nullable=false)
     */
    private $login;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=100, nullable=false)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=61, nullable=false)
     */
    private $firstname = 'not set';

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=61, nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", nullable=false)
     */
    private $type = 'user';


    /**
     * Set id
     *
     * @param integer $id
     * @return Users
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return Users
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set passwd
     *
     * @param string $passwd
     * @return Users
     */
    public function setPassword($passwd)
    {
        $this->password = $passwd;

        return $this;
    }

    /**
     * Get passwd
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Users
     */
    public function setFirstName($name)
    {
        $this->firstname = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getFirstName()
    {
        return $this->firstname;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     * @return Users
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string 
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set avatar
     *
     * @param boolean $avatar
     * @return Users
     */
    public function setAvatar($avatar)
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * Get avatar
     *
     * @return boolean 
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return Users
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set getreports
     *
     * @param string $getreports
     * @return Users
     */
    public function setGetreports($getreports)
    {
        $this->getreports = $getreports;

        return $this;
    }

    /**
     * Get getreports
     *
     * @return string 
     */
    public function getGetreports()
    {
        return $this->getreports;
    }

    /**
     * Set priorityReminder
     *
     * @param string $priorityReminder
     * @return Users
     */
    public function setPriorityReminder($priorityReminder)
    {
        $this->priorityReminder = $priorityReminder;

        return $this;
    }

    /**
     * Get priorityReminder
     *
     * @return string 
     */
    public function getPriorityReminder()
    {
        return $this->priorityReminder;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Users
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set ssoLogged
     *
     * @param boolean $ssoLogged
     * @return Users
     */
    public function setSsoLogged($ssoLogged)
    {
        $this->ssoLogged = $ssoLogged;

        return $this;
    }

    /**
     * Get ssoLogged
     *
     * @return boolean 
     */
    public function getSsoLogged()
    {
        return $this->ssoLogged;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Users
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * Set companyId
     *
     * @param integer $companyId
     * @return Users
     */
    public function setCompanyId($companyId)
    {
        $this->companyId = $companyId;

        return $this;
    }

    /**
     * Get companyId
     *
     * @return integer 
     */
    public function getCompanyId()
    {
        return $this->companyId;
    }

    /**
     * Set currentVersion
     *
     * @param string $currentVersion
     * @return Users
     */
    public function setCurrentVersion($currentVersion)
    {
        $this->currentVersion = $currentVersion;

        return $this;
    }

    /**
     * Get currentVersion
     *
     * @return string 
     */
    public function getCurrentVersion()
    {
        return $this->currentVersion;
    }

    /**
     * Set osVersion
     *
     * @param string $osVersion
     * @return Users
     */
    public function setOsVersion($osVersion)
    {
        $this->osVersion = $osVersion;

        return $this;
    }

    /**
     * Get osVersion
     *
     * @return string 
     */
    public function getOsVersion()
    {
        return $this->osVersion;
    }

    /**
     * Set isWorking
     *
     * @param boolean $isWorking
     * @return Users
     */
    public function setIsWorking($isWorking)
    {
        $this->isWorking = $isWorking;

        return $this;
    }

    /**
     * Get isWorking
     *
     * @return boolean 
     */
    public function getIsWorking()
    {
        return $this->isWorking;
    }

    /**
     * Set updateTime
     *
     * @param \DateTime $updateTime
     * @return Users
     */
    public function setUpdateTime($updateTime)
    {
        $this->updateTime = $updateTime;

        return $this;
    }

    /**
     * Get updateTime
     *
     * @return \DateTime 
     */
    public function getUpdateTime()
    {
        return $this->updateTime;
    }

    /**
     * Set googleApiAccessToken
     *
     * @param string $googleApiAccessToken
     * @return Users
     */
    public function setGoogleApiAccessToken($googleApiAccessToken)
    {
        $this->googleApiAccessToken = $googleApiAccessToken;

        return $this;
    }

    /**
     * Get googleApiAccessToken
     *
     * @return string 
     */
    public function getGoogleApiAccessToken()
    {
        return $this->googleApiAccessToken;
    }

    /**
     * Set googleApiTasks
     *
     * @param string $googleApiTasks
     * @return Users
     */
    public function setGoogleApiTasks($googleApiTasks)
    {
        $this->googleApiTasks = $googleApiTasks;

        return $this;
    }

    /**
     * Get googleApiTasks
     *
     * @return string 
     */
    public function getGoogleApiTasks()
    {
        return $this->googleApiTasks;
    }

    /**
     * Set gdataApiAccessToken
     *
     * @param string $gdataApiAccessToken
     * @return Users
     */
    public function setGdataApiAccessToken($gdataApiAccessToken)
    {
        $this->gdataApiAccessToken = $gdataApiAccessToken;

        return $this;
    }

    /**
     * Get gdataApiAccessToken
     *
     * @return string 
     */
    public function getGdataApiAccessToken()
    {
        return $this->gdataApiAccessToken;
    }

    /**
     * Set gcalendarSessionToken
     *
     * @param string $gcalendarSessionToken
     * @return Users
     */
    public function setGcalendarSessionToken($gcalendarSessionToken)
    {
        $this->gcalendarSessionToken = $gcalendarSessionToken;

        return $this;
    }

    /**
     * Get gcalendarSessionToken
     *
     * @return string 
     */
    public function getGcalendarSessionToken()
    {
        return $this->gcalendarSessionToken;
    }

    /**
     * Set basecampToken
     *
     * @param string $basecampToken
     * @return Users
     */
    public function setBasecampToken($basecampToken)
    {
        $this->basecampToken = $basecampToken;

        return $this;
    }

    /**
     * Get basecampToken
     *
     * @return string 
     */
    public function getBasecampToken()
    {
        return $this->basecampToken;
    }

    /**
     * Set basecampNewAccessToken
     *
     * @param string $basecampNewAccessToken
     * @return Users
     */
    public function setBasecampNewAccessToken($basecampNewAccessToken)
    {
        $this->basecampNewAccessToken = $basecampNewAccessToken;

        return $this;
    }

    /**
     * Get basecampNewAccessToken
     *
     * @return string 
     */
    public function getBasecampNewAccessToken()
    {
        return $this->basecampNewAccessToken;
    }

    /**
     * Set basecampNewRefreshToken
     *
     * @param string $basecampNewRefreshToken
     * @return Users
     */
    public function setBasecampNewRefreshToken($basecampNewRefreshToken)
    {
        $this->basecampNewRefreshToken = $basecampNewRefreshToken;

        return $this;
    }

    /**
     * Get basecampNewRefreshToken
     *
     * @return string 
     */
    public function getBasecampNewRefreshToken()
    {
        return $this->basecampNewRefreshToken;
    }

    /**
     * Set basecampIntegrationDate
     *
     * @param \DateTime $basecampIntegrationDate
     * @return Users
     */
    public function setBasecampIntegrationDate($basecampIntegrationDate)
    {
        $this->basecampIntegrationDate = $basecampIntegrationDate;

        return $this;
    }

    /**
     * Get basecampIntegrationDate
     *
     * @return \DateTime 
     */
    public function getBasecampIntegrationDate()
    {
        return $this->basecampIntegrationDate;
    }

    /**
     * Set jiraUsername
     *
     * @param string $jiraUsername
     * @return Users
     */
    public function setJiraUsername($jiraUsername)
    {
        $this->jiraUsername = $jiraUsername;

        return $this;
    }

    /**
     * Get jiraUsername
     *
     * @return string 
     */
    public function getJiraUsername()
    {
        return $this->jiraUsername;
    }

    /**
     * Set jiraPassword
     *
     * @param string $jiraPassword
     * @return Users
     */
    public function setJiraPassword($jiraPassword)
    {
        $this->jiraPassword = $jiraPassword;

        return $this;
    }

    /**
     * Get jiraPassword
     *
     * @return string 
     */
    public function getJiraPassword()
    {
        return $this->jiraPassword;
    }

    /**
     * Set defaultTasks
     *
     * @param boolean $defaultTasks
     * @return Users
     */
    public function setDefaultTasks($defaultTasks)
    {
        $this->defaultTasks = $defaultTasks;

        return $this;
    }

    /**
     * Get defaultTasks
     *
     * @return boolean 
     */
    public function getDefaultTasks()
    {
        return $this->defaultTasks;
    }

    /**
     * Set desktopLastLogin
     *
     * @param \DateTime $desktopLastLogin
     * @return Users
     */
    public function setDesktopLastLogin($desktopLastLogin)
    {
        $this->desktopLastLogin = $desktopLastLogin;

        return $this;
    }

    /**
     * Get desktopLastLogin
     *
     * @return \DateTime 
     */
    public function getDesktopLastLogin()
    {
        return $this->desktopLastLogin;
    }

    /**
     * Set webFirstLogin
     *
     * @param \DateTime $webFirstLogin
     * @return Users
     */
    public function setWebFirstLogin($webFirstLogin)
    {
        $this->webFirstLogin = $webFirstLogin;

        return $this;
    }

    /**
     * Get webFirstLogin
     *
     * @return \DateTime 
     */
    public function getWebFirstLogin()
    {
        return $this->webFirstLogin;
    }

    /**
     * Set webLastLogin
     *
     * @param \DateTime $webLastLogin
     * @return Users
     */
    public function setWebLastLogin($webLastLogin)
    {
        $this->webLastLogin = $webLastLogin;

        return $this;
    }

    /**
     * Get webLastLogin
     *
     * @return \DateTime 
     */
    public function getWebLastLogin()
    {
        return $this->webLastLogin;
    }

    /**
     * Set userIp
     *
     * @param string $userIp
     * @return Users
     */
    public function setUserIp($userIp)
    {
        $this->userIp = $userIp;

        return $this;
    }

    /**
     * Get userIp
     *
     * @return string 
     */
    public function getUserIp()
    {
        return $this->userIp;
    }

    /**
     * Set parentId
     *
     * @param integer $parentId
     * @return Users
     */
    public function setParentId($parentId)
    {
        $this->parentId = $parentId;

        return $this;
    }

    /**
     * Get parentId
     *
     * @return integer 
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Set trialHours
     *
     * @param string $trialHours
     * @return Users
     */
    public function setTrialHours($trialHours)
    {
        $this->trialHours = $trialHours;

        return $this;
    }

    /**
     * Get trialHours
     *
     * @return string 
     */
    public function getTrialHours()
    {
        return $this->trialHours;
    }

    /**
     * Set v3
     *
     * @param boolean $v3
     * @return Users
     */
    public function setV3($v3)
    {
        $this->v3 = $v3;

        return $this;
    }

    /**
     * Get v3
     *
     * @return boolean 
     */
    public function getV3()
    {
        return $this->v3;
    }
}
