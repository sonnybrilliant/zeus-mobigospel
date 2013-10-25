<?php

namespace Vanessa\CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;



/**
 * Download controller 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class DownloadController extends Controller
{

    public function pullAction($code)
    {
        $this->get('logger')->info('download song code:'.$code);
        
        try{
            $download = $this->get('download.manager')->getByToken($code);
            
        }catch(\Exception $e){
            
        }
        
        return $this->render('VanessaCoreBundle:Download:found.html.twig' );
    }
    

}
