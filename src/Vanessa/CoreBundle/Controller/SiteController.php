<?php

namespace Vanessa\CoreBundle\Controller ;

use Symfony\Bundle\FrameworkBundle\Controller\Controller ;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Ivory\GoogleMap\Overlays\Animation;
use Ivory\GoogleMap\MapTypeId;
use Ivory\GoogleMap\Events\MouseEvent;

/**
 * Site manager 
 * 
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Controller
 * @version 0.0.1
 */
class SiteController extends Controller
{
    /**
     * Main index page
     * 
     * @Cache(expires="+2 days")
     */
    public function indexAction()
    {
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        
        if($mobileDetector->isMobile() && !$mobileDetector->isTablet()){
            return $this->redirect($this->generateUrl('sule_mobile_welcome'));
        }
        
        return $this->render('VanessaCoreBundle:Site:index.html.twig');
    }
    
    /**
     * About us page
     * 
     * @Cache(expires="+2 days")
     */
    public function aboutAction()
    {
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        
        if($mobileDetector->isMobile() && !$mobileDetector->isTablet()){
            return $this->redirect($this->generateUrl('sule_mobile_welcome'));
        }
        
        return $this->render('VanessaCoreBundle:Site:about.html.twig');
    }
    
    /**
     * Contact us page
     * 
     * @Cache(expires="+2 days")
     */
    public function contactAction()
    {
        $mobileDetector = $this->get('mobile_detect.mobile_detector');
        
        if($mobileDetector->isMobile() && !$mobileDetector->isTablet()){
            return $this->redirect($this->generateUrl('sule_mobile_welcome'));
        }
        
        $infoWindow = $this->get('ivory_google_map.info_window');

        // Configure your info window options
        $infoWindow->setPrefixJavascriptVariable('info_window_');
        $infoWindow->setPosition(0, 0, true);
        $infoWindow->setPixelOffset(1.1, 2.1, 'px', 'pt');
        $infoWindow->setContent('<p><strong>'.$this->container->getParameter('site_name').' </strong><br/><small><strong>Telphone </strong>: '.$this->container->getParameter('site_contact').' <br /> <strong>Eamil </strong>: '.$this->container->getParameter('site_email').'</small></p>');
        $infoWindow->setOpen(false);
        $infoWindow->setAutoOpen(true);
        $infoWindow->setOpenEvent(MouseEvent::CLICK);
        $infoWindow->setAutoClose(false);
        $infoWindow->setOption('disableAutoPan', true);
        $infoWindow->setOption('zIndex', 10);
        $infoWindow->setOptions(array(
            'disableAutoPan' => true,
            'zIndex' => 10
        ));
        
        
        
        $marker = $this->get('ivory_google_map.marker');

        // Configure your marker options
        $marker->setPrefixJavascriptVariable('marker_');
        $marker->setPosition(-25.8018, 28.3323,true);
        $marker->setAnimation(Animation::DROP);
        $marker->setOptions(array(
            'clickable' => true,
            'flat' => true
        ));
        $marker->setIcon('http://maps.gstatic.com/mapfiles/markers/marker.png');
        $marker->setShadow('http://maps.gstatic.com/mapfiles/markers/marker.png');
        
        $map = $this->get('ivory_google_map.map');
        // Configure your map options
        $map->setPrefixJavascriptVariable('map_');
        $map->setHtmlContainerId('map_canvas');

        $map->setAsync(false);

        $map->setAutoZoom(false);

        $map->setCenter(-25.8018, 28.3323, true);
        $map->setMapOption('zoom', 16);

        $map->setBound(0, 0, 0, 0, false, false);

        // Sets your map type
        $map->setMapOption('mapTypeId', MapTypeId::ROADMAP);
        $map->setMapOption('mapTypeId', 'roadmap');

        $map->setMapOption('disableDefaultUI', false);
        $map->setMapOption('disableDoubleClickZoom', false);
        $map->setStylesheetOptions(array(
            'width' => '100%',
            'height' => '300px'
        ));

        $map->setLanguage('en');
        
        
        $map->addMarker($marker);
        $marker->setInfoWindow($infoWindow);
        return $this->render('VanessaCoreBundle:Site:contact.html.twig', array('map'=>$map));
    }

}
