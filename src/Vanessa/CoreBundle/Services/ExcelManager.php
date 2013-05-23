<?php

namespace Vanessa\CoreBundle\Services;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Monolog\Logger;

/**
 * Excel manager
 *
 * @author Mfana Ronald Conco <ronald.conco@mobigospel.co.za>
 * @package VanessaCoreBundle
 * @subpackage Services
 * @version 0.0.1
 */
final class ExcelManager
{

    /**
     * Service Container
     * @var object
     */
    private $container = null;

    /**
     * Monolog logger
     * @var object
     */
    private $logger = null;

    /**
     * Excel service
     * @var object
     */
    private $excel;

    /**
     * Class construct
     *
     * @param ContainerInterface $container
     * @param Logger $logger
     * @return void
     */
    public function __construct(
    ContainerInterface $container, Logger $logger)
    {
        $this->setContainer($container);
        $this->setLogger($logger);
        $this->setExcel($container->get('xls.service_xls2007'));
        return;
    }

    public function getContainer()
    {
        return $this->container;
    }

    public function setContainer($container)
    {
        $this->container = $container;
    }

    public function getLogger()
    {
        return $this->logger;
    }

    public function setLogger($logger)
    {
        $this->logger = $logger;
    }

    public function getExcel()
    {
        return $this->excel;
    }

    public function setExcel($excel)
    {
        $this->excel = $excel;
        $this->excel->excelObj->getProperties()->setCreator($this->container->getParameter('site_name'))
            ->setLastModifiedBy($this->container->getParameter('site_name'));
    }
    
    /**
     * Excel member list
     * 
     * @param array $members
     * @return Response
     */
    public function memberList($members)
    {
        $this->excel->excelObj->getProperties()->setTitle($this->container->getParameter('site_name') . " Member listing")
            ->setSubject(" Member Listing")
            ->setDescription("A deatiled list of all members loaded on " . $this->container->getParameter('site_name'))
            ->setKeywords("")
            ->setCategory("List");

        $fileName = 'member-list-' . date('Y-m-d') . '-' . sizeof($members) . '.xlsx';
        
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('A')->setWidth(20);
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('B')->setWidth(20);   
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('C')->setWidth(40);   
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('D')->setWidth(15);   
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('E')->setWidth(40);   
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('F')->setWidth(10);   
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('G')->setWidth(30);   
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('H')->setWidth(8);   
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('I')->setWidth(8);   
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('J')->setWidth(10);   
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('K')->setWidth(10);   
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('L')->setWidth(10);   
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('M')->setWidth(10);   
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('N')->setWidth(20);   
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('O')->setWidth(20);   
        $this->excel->excelObj->getActiveSheet()->getColumnDimension('P')->setWidth(20);   
        
        $this->excel->excelObj->setActiveSheetIndex(0)
                    ->setCellValue('A1', "First name")
                    ->setCellValue('B1', "Last name")
                    ->setCellValue('C1', "Email address")
                    ->setCellValue('D1', "Mobile number")
                    ->setCellValue('E1', "Agency")
                    ->setCellValue('F1', "Status")
                    ->setCellValue('G1', "Role")
                    ->setCellValue('H1', "Title")
                    ->setCellValue('I1', "Gender")
                    ->setCellValue('J1', "Is Admin")
                    ->setCellValue('K1', "Is Deleted")
                    ->setCellValue('L1', "Is Enabled")
                    ->setCellValue('M1', "Is Expired")
                    ->setCellValue('N1', "Expires At")
                    ->setCellValue('O1', "Created At")
                    ->setCellValue('P1', "Updated At");
        $this->excel->excelObj->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
        $this->excel->excelObj->getActiveSheet()->getStyle('C1:D1')->getFont()->setBold(true);
        $this->excel->excelObj->getActiveSheet()->getStyle('E1:F1')->getFont()->setBold(true);
        $this->excel->excelObj->getActiveSheet()->getStyle('G1:H1')->getFont()->setBold(true);
        $this->excel->excelObj->getActiveSheet()->getStyle('I1:J1')->getFont()->setBold(true);
        $this->excel->excelObj->getActiveSheet()->getStyle('K1:L1')->getFont()->setBold(true);
        $this->excel->excelObj->getActiveSheet()->getStyle('M1:N1')->getFont()->setBold(true);
        $this->excel->excelObj->getActiveSheet()->getStyle('O1:P1')->getFont()->setBold(true);
        $counter = 2;
        foreach ($members as $member) {
            $this->excel->excelObj->setActiveSheetIndex(0)
                    ->setCellValue('A' . $counter, $member->getFirstName())
                    ->setCellValue('B' . $counter, $member->getLastName())
                    ->setCellValue('C' . $counter, $member->getEmail())
                    ->setCellValue('D' . $counter, $member->getMobileNumber())
                    ->setCellValue('E' . $counter, $member->getAgency()->getName())
                    ->setCellValue('F' . $counter, $member->getStatus()->getName())
                    ->setCellValue('G' . $counter, $member->getGroup()->getName())
                    ->setCellValue('H' . $counter, $member->getTitle()->getTitle())
                    ->setCellValue('I' . $counter, $member->getGender()->getName())
                    ->setCellValue('J' . $counter, $member->getIsAdmin())
                    ->setCellValue('K' . $counter, $member->getIsDeleted())
                    ->setCellValue('L' . $counter, $member->getEnabled())
                    ->setCellValue('M' . $counter, $member->getExpired())
                    ->setCellValue('N' . $counter, $member->getExpiresAt()->format('Y-m-d H:i A'))
                    ->setCellValue('O' . $counter, $member->getCreatedAt()->format('Y-m-d H:i A'))
                    ->setCellValue('P' . $counter, $member->getUpdatedAt()->format('Y-m-d H:i A'));
            $counter++;
        }

        $this->excel->excelObj->getActiveSheet()->setTitle('Listing');
        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $this->excel->excelObj->setActiveSheetIndex(0);

        //create the response
        $response = $this->excel->getResponse();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename='.$fileName);

        // If you are using a https connection, you have to set those two headers for compatibility with IE <9
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;
    }

}