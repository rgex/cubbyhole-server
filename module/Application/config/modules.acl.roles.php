<?php

return array('guest'=>    array('Application\Controller\Index\login',
                                'Application\Controller\Index\index',
                                'Application\Controller\Index\register',
                                'Application\Controller\Captcha\generate',
                                'Application\Controller\Index\offer',
                                'Application\Controller\Customer\files',

                                //webservice
                                'Application\Controller\Ws\getUserWithToken',
                                'Application\Controller\Ws\updateDiskSpace',

                                //cronjob
                                'Application\Controller\Cronjob\updateWorkers',

                                //test
                                'Application\Controller\SeleniumTest\loginTest',
             ),
    
             'Customer'=> array('Application\Controller\Index\login',
                                'Application\Controller\Index\index',
                                'Application\Controller\Index\register',
                                'Application\Controller\Index\logout',
                                'Application\Controller\Captcha\generate',
                                'Application\Controller\Index\offer',
                                'Application\Controller\Customer\index',
                                'Application\Controller\Customer\offers',
                                'Application\Controller\Customer\files',

                                //webservice
                                'Application\Controller\Ws\getUserWithToken',
                                'Application\Controller\Ws\updateDiskSpace',
             ),

             'Admin'=>    array('Application\Controller\Index\login',
                                'Application\Controller\Index\index',
                                'Application\Controller\Index\register',
                                'Application\Controller\Index\logout',
                                'Application\Controller\Captcha\generate',
                                'Application\Controller\Index\offer',
                                'Application\Controller\Customer\files',


                                //Admin specific
                                'Admin\Controller\Stats\index',

                                'Admin\Controller\User\index',
                                'Admin\Controller\User\edit',

                                'Admin\Controller\Offer\index',
                                'Admin\Controller\Offer\new',
                                'Admin\Controller\Offer\edit',

                                'Admin\Controller\Worker\index',
                                'Admin\Controller\Worker\new',
                                'Admin\Controller\Worker\edit',


                                //webservice
                                'Application\Controller\Ws\getUserWithToken',
                                'Application\Controller\Ws\updateDiskSpace',
             ),
    );