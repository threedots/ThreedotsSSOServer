<?php

namespace TestEngine\Bundle\CoreBundle\Service;


class Auth extends Base
{

    protected $roleRepository;
    protected $packageRepository;
    protected $accountRepository;
    protected $companiesRepository;
    protected $companyUsersRepository;
    protected $companyUserPermissionsRepository;

    public function initRepositories()
    {
        $this->roleRepository                   = $this->get('roles_repository');
        $this->packageRepository                = $this->get('packages_repository');
        $this->accountRepository                = $this->get('account_repository');
        $this->companiesRepository              = $this->get('companies_repository');
        $this->companyUsersRepository           = $this->get('companyuser_repository');
        $this->companyUserPermissionsRepository = $this->get('companyuserpermissions_repository');
    }

    public function hasPermission($userId, $roleType)
    {

    }

    public function checkLogin($data)
    {
        $this->initRepositories();


        $userInfo = $this->companyUsersRepository->getInfo($data['user_name'], $data['password']);

        if ($userInfo->getIsAccountAdmin()) {

            $ownerInfo = $this->accountRepository->getInfo($userInfo->getId());

            if ($ownerInfo){
                $companyInfo = $this->companiesRepository->getByAccountId($ownerInfo->getId());
                $packagePermissions = $this->packageRepository->getById($ownerInfo->getPackageId());
                if ($packagePermissions) {
                    $permissions = $this->roleRepository->getRolesNameById($packagePermissions->getRoles());
                }
            }


        }else{

            $userPermissions = $this->companyUserPermissionsRepository->getCompanyWithPermissionsByUserId($userInfo->getId());

            if ($userPermissions) {
                foreach($userPermissions as $userPermission){
                    $companyInfo = $this->companiesRepository->getById($userPermission->getCompanyId());
                    $permissions = $this->roleRepository->getRolesNameById($userPermission->getRoles());
                }
            }

        }
    }

    public function isLoggedIn()
    {

    }

    public function isCompanyOwner($useId)
    {

    }

    public function isCompanyManager($userId)
    {

    }

    public function getUserPermissionByCompany($userId, $companyId)
    {

    }

    public function installDummyData()
    {
        $this->initRepositories();

        $roles = array(
            array('role_id' => 1, 'name' => 'ROLE_COMPANY_MANAGER'),
            array('role_id' => 2, 'name' => 'ROLE_USER_MANAGER'),
            array('role_id' => 3, 'name' => 'ROLE_TEST_MANAGER'),
            array('role_id' => 4, 'name' => 'ROLE_TEST_REPOTER'),
            array('role_id' => 5, 'name' => 'ROLE_TEST_CREATER'),
        );

        foreach($roles as $role){
            $this->roleRepository->addRole($role);
        }

        $packages = array(
            array('id' => 1, 'title' => 'Platinum',  'roles' => '1,2,3,4,5', 'limit_company_count' => 10, 'limit_user_count' => 20),
            array('id' => 2, 'title' => 'Gold',      'roles' => '1,2,3',     'limit_company_count' => 5,  'limit_user_count' => 10),
            array('id' => 3, 'title' => 'Silver',    'roles' => '4,5',       'limit_company_count' => 2,  'limit_user_count' => 5)
        );

        foreach($packages as $package){
            $this->packageRepository->addPackage($package);
        }

        $accounts = array(
            array('id' => 1, 'user_id' => 1, 'package_id' => '1', 'current_number_of_companies' => 0, 'current_number_of_users' => 0)
        );

        foreach($accounts as $account){
            $this->accountRepository->addAccount($account);
        }

        $companies = array(
            array('id' => 1, 'name' => 'Invesp', 		  'account_id' => 1 ),
            array('id' => 2, 'name' => 'InversionGarage', 'account_id' => 1 )
        );

        foreach($companies as $company){
            $this->companiesRepository->addCompany($company);
        }

        $company_users = array(
              array('id' => 1, 'user_name' => 'asad',   'password' => '123456', 'is_account_admin' => true),
	          array('id' => 2, 'user_name' => 'masud',  'password' => '123456', 'is_account_admin' => false),
	          array('id' => 3, 'user_name' => 'rezwan', 'password' => '123456', 'is_account_admin' => false)
        );

        foreach($company_users as $cu){
            $this->companyUsersRepository->addCompanyUser($cu);
        }

        $company_user_permissions = array(
            array('id' => 1, 'company_id' => 1, 'user_id' => 2 , 'roles' =>'2,3,4,5' ),
        	array('id' => 1, 'company_id' => 1, 'user_id' => 3 , 'roles' =>'4,5' )
        );

        foreach($company_user_permissions as $cup){
            $this->companyUserPermissionsRepository->addCompanyUserPermission($cup);
        }
    }

}