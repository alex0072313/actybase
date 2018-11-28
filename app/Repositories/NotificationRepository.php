<?php

namespace App\Repositories;

use App\Company;
use App\Notification;
use App\User;
use Image;
use Storage;
use Auth;

abstract class NotificationRepository extends Repository
{

    public static function CompanyBestbeforeSoonEnd(User $user, Company $company){

        if($user->checkNotify('user_company_bestbefore_soon_end')){
            return false;
        }

        $user->addNotification('user_company_bestbefore_soon_end', 'Предупреждение о работе компании', 'Срок дейстявия вашей компании закончится '.$company->bestbefore.'. Для продления обратитесь к администратору сервиса.');
    }

    public static function CompanyStatusInnactive(User $user){

        if($user->checkNotify('user_company_innactive')){
            return false;
        }

        $user->addNotification('user_company_innactive', 'Изменение статуса компании', 'Ваша компания помечена как неактивная. Обратитесь к администратору сервиса.');

    }



}