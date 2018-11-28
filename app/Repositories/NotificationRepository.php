<?php

namespace App\Repositories;

use App\Company;
use App\Notification;
use App\User;
use Image;
use Storage;
use Auth;
use Carbon;

abstract class NotificationRepository extends Repository
{

    public static function CompanyBestbeforeSoonEnd(User $user, Company $company){

        if($user->checkNotify('user_company_bestbefore_soon_end')){
            return false;
        }

        $user->addNotification('user_company_bestbefore_soon_end',
            'Работа компании',
            'Срок действия Вашей компании закончится '.Carbon::parse($company->bestbefore)->toFormattedDateString().'. Для продления обратитесь к администратору сервиса.',
            1);
    }

    public static function CompanyBestbeforeEnd(User $user){

        if($user->checkNotify('user_company_bestbefore_end')){
            return false;
        }

        $user->addNotification('user_company_bestbefore_end',
            'Остановка компании',
            'Срок действия Вашей компании истек. Для продления обратитесь к администратору сервиса.',
            0);
    }

    public static function CompanyStatusInnactive(User $user){

        if($user->checkNotify('user_company_innactive')){
            return false;
        }

        $user->addNotification('user_company_innactive',
            'Отключение компании',
            'Ваша компания помечена как неактивная. Обратитесь к администратору сервиса.');

    }

    public static function CompanyBestbeforeStart(User $user, Company $company){

        if($user->checkNotify('user_company_bestbefore_start')){
            return false;
        }

        $user->addNotification('user_company_bestbefore_start',
            'Активация компании',
            'Ваша компания снова активна. Срок действия до '.Carbon::parse($company->bestbefore)->toFormattedDateString(),
            2);
    }



}