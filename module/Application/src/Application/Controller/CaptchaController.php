<?php

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

class CaptchaController extends AbstractActionController
{

    public function generateAction()
    {
            $response = $this->getResponse();
            $response->getHeaders()->addHeaderLine('Content-Type','image/png');
            
            $id = (int)$this->params('id',false);
                    
            if($id)
            {
                $image = './data/captcha/'.$id;
                if(file_exists($image) != false)
                {
                    $imageContent = file_get_contents($image);
                    $response->setStatusCode(200);
                    $response->setContent($imageContent);
                }
            }
            
            return $response;
    }
    
}
