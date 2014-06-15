<?php

return array('guest'=>    array('Application\Controller\Index\login',
                                'Application\Controller\Index\index',
                                'Application\Controller\Index\register',
                                'Application\Controller\Captcha\generate',

             ),
    
             'Customer'=> array('Application\Controller\Index\login',
                                'Application\Controller\Index\index',
                                'Application\Controller\Index\register',
                                'Application\Controller\Index\logout',
                                'Application\Controller\Captcha\generate',
             ),

             'Admin'=>    array('Application\Controller\Index\login',
                                'Application\Controller\Index\index',
                                'Application\Controller\Index\register',
                                'Application\Controller\Index\logout',
                                'Application\Controller\Captcha\generate',


                                //Admin specific
                                'Admin\Controller\Index\index',

                                'Admin\Controller\User\index',
                                'Admin\Controller\User\edit',

                                'Admin\Controller\Offer\index',
                                'Admin\Controller\Offer\new',
                                'Admin\Controller\Offer\edit',
             ),
    );