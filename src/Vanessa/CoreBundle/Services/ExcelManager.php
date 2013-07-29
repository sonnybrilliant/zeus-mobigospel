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
     * Create member sheet
     * 
     * @param array $members
     * @param integer $index
     * @return void
     */
    private function memberSheet($members, $index = 0)
    {
        $sheet = $this->excel->excelObj->createSheet($index);

        $sheet->getColumnDimension('A')->setWidth(20);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(40);
        $sheet->getColumnDimension('D')->setWidth(15);
        $sheet->getColumnDimension('E')->setWidth(40);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(30);
        $sheet->getColumnDimension('H')->setWidth(8);
        $sheet->getColumnDimension('I')->setWidth(8);
        $sheet->getColumnDimension('J')->setWidth(10);
        $sheet->getColumnDimension('K')->setWidth(10);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(10);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(20);
        $sheet->getColumnDimension('P')->setWidth(20);

        $sheet->setCellValue('A1', "First name")
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
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $sheet->getStyle('C1:D1')->getFont()->setBold(true);
        $sheet->getStyle('E1:F1')->getFont()->setBold(true);
        $sheet->getStyle('G1:H1')->getFont()->setBold(true);
        $sheet->getStyle('I1:J1')->getFont()->setBold(true);
        $sheet->getStyle('K1:L1')->getFont()->setBold(true);
        $sheet->getStyle('M1:N1')->getFont()->setBold(true);
        $sheet->getStyle('O1:P1')->getFont()->setBold(true);
        $counter = 2;
        foreach ($members as $member) {
           $this->excel->excelObj->setActiveSheetIndex($index)
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

        $sheet->setTitle('Member listing');
        return;
    }
    
    /**
     * Create content owner sheet
     * 
     * @param array $contentOwners
     * @param integer $index
     * @return void
     */
    private function contentOwnersSheet($contentOwners,$index = 0)
    {
        $sheet = $this->excel->excelObj->createSheet($index);
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(40);
        $sheet->getColumnDimension('K')->setWidth(10);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(10);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(20);
        $sheet->getColumnDimension('P')->setWidth(20);

        $this->excel->excelObj->setActiveSheetIndex($index)
            ->setCellValue('A1', "#Id")
            ->setCellValue('B1', "Name")
            ->setCellValue('C1', "Slug")
            ->setCellValue('D1', "Account number")
            ->setCellValue('E1', "Status")
            ->setCellValue('F1', "Is Deleted")
            ->setCellValue('G1', "Is Enabled")
            ->setCellValue('H1', "Contact person")
            ->setCellValue('I1', "Contact number")
            ->setCellValue('J1', "Contact email address")
            ->setCellValue('K1', "Artist")
            ->setCellValue('L1', "Songs")
            ->setCellValue('M1', "Codes")
            ->setCellValue('N1', "Created At")
            ->setCellValue('O1', "Updated At")
            ->setCellValue('P1', "");
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $sheet->getStyle('C1:D1')->getFont()->setBold(true);
        $sheet->getStyle('E1:F1')->getFont()->setBold(true);
        $sheet->getStyle('G1:H1')->getFont()->setBold(true);
        $sheet->getStyle('I1:J1')->getFont()->setBold(true);
        $sheet->getStyle('K1:L1')->getFont()->setBold(true);
        $sheet->getStyle('M1:N1')->getFont()->setBold(true);
        $sheet->getStyle('O1:P1')->getFont()->setBold(true);
        $counter = 2;
        foreach ($contentOwners as $contentOwner) {
            $this->excel->excelObj->setActiveSheetIndex($index)
                ->setCellValue('A' . $counter, $contentOwner->getId())
                ->setCellValue('B' . $counter, $contentOwner->getName())
                ->setCellValue('C' . $counter, $contentOwner->getSlug())
                ->setCellValue('D' . $counter, $contentOwner->getAccountNumber())
                ->setCellValue('E' . $counter, $contentOwner->getStatus()->getName())
                ->setCellValue('F' . $counter, $contentOwner->getIsDeleted())
                ->setCellValue('G' . $counter, $contentOwner->getEnabled())
                ->setCellValue('H' . $counter, $contentOwner->getContactPerson())
                ->setCellValue('I' . $counter, $contentOwner->getContactNumber())
                ->setCellValue('J' . $counter, $contentOwner->getContactEmail())
                ->setCellValue('K' . $counter, 0)
                ->setCellValue('L' . $counter, 0)
                ->setCellValue('M' . $counter, 0)
                ->setCellValue('N' . $counter, $contentOwner->getCreatedAt()->format('Y-m-d H:i A'))
                ->setCellValue('O' . $counter, $contentOwner->getUpdatedAt()->format('Y-m-d H:i A'))
                ->setCellValue('P' . $counter, '');
            $counter++;
        }

        $sheet->setTitle('Content owners listing');
        return;
    }
    
    /**
     * Create reseller sheet
     * 
     * @param array $resellers
     * @param integer $index
     * @return void
     */
    private function resellerSheet($resellers,$index = 0)
    {
        $sheet = $this->excel->excelObj->createSheet($index);
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(30);
        $sheet->getColumnDimension('C')->setWidth(30);
        $sheet->getColumnDimension('D')->setWidth(10);
        $sheet->getColumnDimension('E')->setWidth(10);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(30);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(40);
        $sheet->getColumnDimension('K')->setWidth(10);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(10);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(20);
        $sheet->getColumnDimension('P')->setWidth(20);

        $this->excel->excelObj->setActiveSheetIndex($index)
            ->setCellValue('A1', "#Id")
            ->setCellValue('B1', "Name")
            ->setCellValue('C1', "Slug")
            ->setCellValue('D1', "Account number")
            ->setCellValue('E1', "Status")
            ->setCellValue('F1', "Is Deleted")
            ->setCellValue('G1', "Is Enabled")
            ->setCellValue('H1', "Contact person")
            ->setCellValue('I1', "Contact number")
            ->setCellValue('J1', "Contact email address")
            ->setCellValue('K1', "Artist")
            ->setCellValue('L1', "Songs")
            ->setCellValue('M1', "Codes")
            ->setCellValue('N1', "Created At")
            ->setCellValue('O1', "Updated At")
            ->setCellValue('P1', "");
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $sheet->getStyle('C1:D1')->getFont()->setBold(true);
        $sheet->getStyle('E1:F1')->getFont()->setBold(true);
        $sheet->getStyle('G1:H1')->getFont()->setBold(true);
        $sheet->getStyle('I1:J1')->getFont()->setBold(true);
        $sheet->getStyle('K1:L1')->getFont()->setBold(true);
        $sheet->getStyle('M1:N1')->getFont()->setBold(true);
        $sheet->getStyle('O1:P1')->getFont()->setBold(true);
        $counter = 2;
        foreach ($resellers as $reseller) {
            $this->excel->excelObj->setActiveSheetIndex($index)
                ->setCellValue('A' . $counter, $reseller->getId())
                ->setCellValue('B' . $counter, $reseller->getName())
                ->setCellValue('C' . $counter, $reseller->getSlug())
                ->setCellValue('D' . $counter, $reseller->getAccountNumber())
                ->setCellValue('E' . $counter, $reseller->getStatus()->getName())
                ->setCellValue('F' . $counter, $reseller->getIsDeleted())
                ->setCellValue('G' . $counter, $reseller->getEnabled())
                ->setCellValue('H' . $counter, $reseller->getContactPerson())
                ->setCellValue('I' . $counter, $reseller->getContactNumber())
                ->setCellValue('J' . $counter, $reseller->getContactEmail())
                ->setCellValue('K' . $counter, 0)
                ->setCellValue('L' . $counter, 0)
                ->setCellValue('M' . $counter, 0)
                ->setCellValue('N' . $counter, $reseller->getCreatedAt()->format('Y-m-d H:i A'))
                ->setCellValue('O' . $counter, $reseller->getUpdatedAt()->format('Y-m-d H:i A'))
                ->setCellValue('P' . $counter, '');
            $counter++;
        }

        $sheet->setTitle('Reseller listing');
        return;
    }
    
    /**
     * Create artists sheet
     * 
     * @param array $artists
     * @param integer $index
     * @return void
     */
    private function artistSheet($artists,$index = 0)
    {
        $sheet = $this->excel->excelObj->createSheet($index);
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(10);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(20);
        $sheet->getColumnDimension('J')->setWidth(10);
        $sheet->getColumnDimension('K')->setWidth(10);
        $sheet->getColumnDimension('L')->setWidth(10);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(20);
        $sheet->getColumnDimension('P')->setWidth(20);

        $this->excel->excelObj->setActiveSheetIndex($index)
            ->setCellValue('A1', "#Id")
            ->setCellValue('B1', "Is Group")
            ->setCellValue('C1', "Stage name")
            ->setCellValue('D1', "First name")
            ->setCellValue('E1', "Middle name")
            ->setCellValue('F1', "Last name")
            ->setCellValue('G1', "Gender")
            ->setCellValue('H1', "Status")
            ->setCellValue('I1', "Genres")
            ->setCellValue('J1', "Agency")
            ->setCellValue('K1', "Is Deleted")
            ->setCellValue('L1', "Is Enabled")
            ->setCellValue('M1', "Songs")
            ->setCellValue('N1', "Created By")
            ->setCellValue('O1', "Created At")
            ->setCellValue('P1', "Updated At")
            ->setCellValue('Q1', "");
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $sheet->getStyle('C1:D1')->getFont()->setBold(true);
        $sheet->getStyle('E1:F1')->getFont()->setBold(true);
        $sheet->getStyle('G1:H1')->getFont()->setBold(true);
        $sheet->getStyle('I1:J1')->getFont()->setBold(true);
        $sheet->getStyle('K1:L1')->getFont()->setBold(true);
        $sheet->getStyle('M1:N1')->getFont()->setBold(true);
        $sheet->getStyle('O1:P1')->getFont()->setBold(true);
        $counter = 2;
        foreach ($artists as $artist) {
            $genres = "";
            foreach($artist->getGenres() as $genre){
               $genres .= '['.$genre->getName().']'; 
            }
            $this->excel->excelObj->setActiveSheetIndex($index)
                ->setCellValue('A' . $counter, $artist->getId())
                ->setCellValue('B' . $counter, $artist->getIsGroup()? "Yes" : "No")                
                ->setCellValue('C' . $counter, $artist->getStageName())
                ->setCellValue('D' . $counter, $artist->getFirstName())
                ->setCellValue('E' . $counter, $artist->getMiddleName())
                ->setCellValue('F' . $counter, $artist->getLastName())
                ->setCellValue('G' . $counter, $artist->getGender() ? $artist->getGender()->getName() : '')
                ->setCellValue('H' . $counter, $artist->getStatus()->getName())
                ->setCellValue('I' . $counter, $genres)
                ->setCellValue('J' . $counter, $artist->getAgency()->getName())
                ->setCellValue('K' . $counter, $artist->getIsDeleted())
                ->setCellValue('L' . $counter, $artist->getEnabled())
                ->setCellValue('M' . $counter, 0)
                ->setCellValue('N' . $counter, $artist->getCreatedBy()->getFullName())
                ->setCellValue('O' . $counter, $artist->getCreatedAt()->format('Y-m-d H:i A'))
                ->setCellValue('P' . $counter, $artist->getUpdatedAt()->format('Y-m-d H:i A'))
                ->setCellValue('Q' . $counter, '');
            $counter++;
        }

        $sheet->setTitle('Artist listing');
        return;
    }
    
    /**
     * Create pending song sheet
     * 
     * @param array $songs
     * @param integer $index
     * @return void
     */
    private function pendingSongSheet($songs,$index = 0)
    {
        $sheet = $this->excel->excelObj->createSheet($index);
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(10);
        $sheet->getColumnDimension('J')->setWidth(20);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(20);
        $sheet->getColumnDimension('P')->setWidth(20);

        $this->excel->excelObj->setActiveSheetIndex($index)
            ->setCellValue('A1', "#Id")
            ->setCellValue('B1', "Title")
            ->setCellValue('C1', "Slug")
            ->setCellValue('D1', "Artist")
            ->setCellValue('E1', "Featured Artist")
            ->setCellValue('F1', "Agency")
            ->setCellValue('G1', "Status")
            ->setCellValue('H1', "Genres")
            ->setCellValue('I1', "Is Deleted")
            ->setCellValue('J1', "Is Active")
            ->setCellValue('K1', "Uploaded By")
            ->setCellValue('L1', "Created At")
            ->setCellValue('M1', "Updated At")
            ->setCellValue('N1', "Rejected Message")
            ->setCellValue('O1', "Rejected By")
            ->setCellValue('P1', "Rejected At");
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $sheet->getStyle('C1:D1')->getFont()->setBold(true);
        $sheet->getStyle('E1:F1')->getFont()->setBold(true);
        $sheet->getStyle('G1:H1')->getFont()->setBold(true);
        $sheet->getStyle('I1:J1')->getFont()->setBold(true);
        $sheet->getStyle('K1:L1')->getFont()->setBold(true);
        $sheet->getStyle('M1:N1')->getFont()->setBold(true);
        $sheet->getStyle('O1:P1')->getFont()->setBold(true);
        $counter = 2;
        foreach ($songs as $song) {
            $genres = "";
            foreach($song->getGenres() as $genre){
               $genres .= '['.$genre->getName().']'; 
            }
            $this->excel->excelObj->setActiveSheetIndex($index)
                ->setCellValue('A' . $counter, $song->getId())
                ->setCellValue('B' . $counter, $song->getTitle())                
                ->setCellValue('C' . $counter, $song->getSlug())
                ->setCellValue('D' . $counter, $song->getArtist()->getStageName())
                ->setCellValue('E' . $counter, $song->getFeaturedArtist())
                ->setCellValue('F' . $counter, $song->getAgency()->getName())
                ->setCellValue('G' . $counter, $song->getStatus()->getName())
                ->setCellValue('H' . $counter, $genres)
                ->setCellValue('I' . $counter, $song->getIsDeleted())
                ->setCellValue('J' . $counter, $song->getIsActive())
                ->setCellValue('K' . $counter, $song->getCreatedBy()->getFullName())
                ->setCellValue('L' . $counter, $song->getCreatedAt()->format('Y-m-d H:i A'))
                ->setCellValue('M' . $counter, $song->getUpdatedAt()->format('Y-m-d H:i A'))
                ->setCellValue('N' . $counter, $song->getRejectMessage())
                ->setCellValue('O' . $counter, $song->getRejectedBy() ? $song->getRejectedBy()->getFullName():'')
                ->setCellValue('P' . $counter, $song->getRejectedAt()? $song->getRejectedAt()->format('Y-m-d H:i A') : '');
            $counter++;
        }

        $sheet->setTitle('Pending songs listing');
        return;
    }    
    
    /**
     * Create active song sheet
     * 
     * @param array $songs
     * @param integer $index
     * @return void
     */
    private function activeSongSheet($songs,$index = 0)
    {
        $sheet = $this->excel->excelObj->createSheet($index);
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(10);
        $sheet->getColumnDimension('J')->setWidth(10);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(20);
        $sheet->getColumnDimension('P')->setWidth(20);

        $this->excel->excelObj->setActiveSheetIndex($index)
            ->setCellValue('A1', "#Id")
            ->setCellValue('B1', "Title")
            ->setCellValue('C1', "Slug")
            ->setCellValue('D1', "Artist")
            ->setCellValue('E1', "Featured Artist")
            ->setCellValue('F1', "Agency")
            ->setCellValue('G1', "Status")
            ->setCellValue('H1', "Genres")
            ->setCellValue('I1', "Is Deleted")
            ->setCellValue('J1', "Is Active")
            ->setCellValue('K1', "Uploaded By")
            ->setCellValue('L1', "Created At")
            ->setCellValue('M1', "Updated At")
            ->setCellValue('N1', "");
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $sheet->getStyle('C1:D1')->getFont()->setBold(true);
        $sheet->getStyle('E1:F1')->getFont()->setBold(true);
        $sheet->getStyle('G1:H1')->getFont()->setBold(true);
        $sheet->getStyle('I1:J1')->getFont()->setBold(true);
        $sheet->getStyle('K1:L1')->getFont()->setBold(true);
        $sheet->getStyle('M1:N1')->getFont()->setBold(true);
        $counter = 2;
        foreach ($songs as $song) {
            $genres = "";
            foreach($song->getGenres() as $genre){
               $genres .= '['.$genre->getName().']'; 
            }
            $this->excel->excelObj->setActiveSheetIndex($index)
                ->setCellValue('A' . $counter, $song->getId())
                ->setCellValue('B' . $counter, $song->getTitle())                
                ->setCellValue('C' . $counter, $song->getSlug())
                ->setCellValue('D' . $counter, $song->getArtist()->getStageName())
                ->setCellValue('E' . $counter, $song->getSongTemp()->getFeaturedArtist())
                ->setCellValue('F' . $counter, $song->getAgency()->getName())
                ->setCellValue('G' . $counter, $song->getStatus()->getName())
                ->setCellValue('H' . $counter, $genres)
                ->setCellValue('I' . $counter, $song->getIsDeleted())
                ->setCellValue('J' . $counter, $song->getIsActive())
                ->setCellValue('K' . $counter, $song->getCreatedBy()->getFullName())
                ->setCellValue('L' . $counter, $song->getCreatedAt()->format('Y-m-d H:i A'))
                ->setCellValue('M' . $counter, $song->getUpdatedAt()->format('Y-m-d H:i A'))
                ->setCellValue('N' . $counter, "");
            $counter++;
        }

        $sheet->setTitle('Active songs listing');
        return;
    }    
    
    /**
     * Create active code sheet
     * 
     * @param array $codes
     * @param integer $index
     * @return void
     */
    private function codesSheet($codes,$index = 0)
    {
        $sheet = $this->excel->excelObj->createSheet($index);
        
        $sheet->getColumnDimension('A')->setWidth(5);
        $sheet->getColumnDimension('B')->setWidth(20);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        $sheet->getColumnDimension('E')->setWidth(20);
        $sheet->getColumnDimension('F')->setWidth(20);
        $sheet->getColumnDimension('G')->setWidth(10);
        $sheet->getColumnDimension('H')->setWidth(20);
        $sheet->getColumnDimension('I')->setWidth(10);
        $sheet->getColumnDimension('J')->setWidth(10);
        $sheet->getColumnDimension('K')->setWidth(20);
        $sheet->getColumnDimension('L')->setWidth(20);
        $sheet->getColumnDimension('M')->setWidth(20);
        $sheet->getColumnDimension('N')->setWidth(20);
        $sheet->getColumnDimension('O')->setWidth(20);
        $sheet->getColumnDimension('P')->setWidth(20);

        $this->excel->excelObj->setActiveSheetIndex($index)
            ->setCellValue('A1', "#Id")
            ->setCellValue('B1', "Code")
            ->setCellValue('C1', "Song")
            ->setCellValue('D1', "Artist")
            ->setCellValue('E1', "Featured Artist")
            ->setCellValue('F1', "Agency")
            ->setCellValue('G1', "Status")
            ->setCellValue('H1', "Downloads")
            ->setCellValue('I1', "Is Deleted")
            ->setCellValue('J1', "Is Active")
            ->setCellValue('K1', "Created By")
            ->setCellValue('L1', "Created At")
            ->setCellValue('L1', "Updated At")
            ->setCellValue('M1', "Disabled By")
            ->setCellValue('N1', "Disabled At");
        $sheet->getStyle('A1:B1')->getFont()->setBold(true);
        $sheet->getStyle('C1:D1')->getFont()->setBold(true);
        $sheet->getStyle('E1:F1')->getFont()->setBold(true);
        $sheet->getStyle('G1:H1')->getFont()->setBold(true);
        $sheet->getStyle('I1:J1')->getFont()->setBold(true);
        $sheet->getStyle('K1:L1')->getFont()->setBold(true);
        $sheet->getStyle('M1:N1')->getFont()->setBold(true);
        $counter = 2;
        foreach ($codes as $code) {
            $this->excel->excelObj->setActiveSheetIndex($index)
                ->setCellValue('A' . $counter, $code->getId())
                ->setCellValue('B' . $counter, $code->getCode())                
                ->setCellValue('C' . $counter, $code->getSong()->getTitle())                
                ->setCellValue('D' . $counter, $code->getSong()->getArtist()->getStageName())                
                ->setCellValue('E' . $counter, $code->getSong()->getFeaturedArtist())                
                ->setCellValue('F' . $counter, $code->getAgency()->getName())                
                ->setCellValue('G' . $counter, $code->getStatus()->getName())
                ->setCellValue('H' . $counter, $code->getDownloadCounter())
                ->setCellValue('I' . $counter, $code->getIsDeleted())
                ->setCellValue('J' . $counter, $code->getIsActive())
                ->setCellValue('K' . $counter, $code->getCreatedBy()->getFullName())
                ->setCellValue('L' . $counter, $code->getCreatedAt()->format('Y-m-d H:i A'))
                ->setCellValue('M' . $counter, $code->getUpdatedAt()->format('Y-m-d H:i A'))
                ->setCellValue('N' . $counter, $code->getDisabledBy()? $code->getDisabledBy()->getFullName():"")
                ->setCellValue('O' . $counter, $code->getDisabledAt()? $code->getDisabledAt()->format('Y-m-d H:i A'):"");
            $counter++;
        }

        $sheet->setTitle('Codes listing');
        return;
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
        
        $this->memberSheet($members,0);
        
        //create the response
        $response = $this->excel->getResponse();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $fileName);

        // If you are using a https connection, you have to set those two headers for compatibility with IE <9
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;
    }

    /**
     * Excel content owner list
     * 
     * @param array $contentOwners
     * @return Response
     */
    public function contentOwnerList($contentOwners)
    {
        $this->excel->excelObj->getProperties()->setTitle($this->container->getParameter('site_name') . " Content Owner listing")
            ->setSubject(" Content Owner Listing")
            ->setDescription("A deatiled list of all Content Owner loaded on " . $this->container->getParameter('site_name'))
            ->setKeywords("")
            ->setCategory("List");

        $fileName = 'content-owner-list-' . date('Y-m-d') . '-' . sizeof($contentOwners) . '.xlsx';

        $this->contentOwnersSheet($contentOwners, 0);
        
        //create the response
        $response = $this->excel->getResponse();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $fileName);

        // If you are using a https connection, you have to set those two headers for compatibility with IE <9
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;
    }

    /**
     * Excel reseller list
     * 
     * @param array $reseller
     * @return Response
     */
    public function resellerList($reseller)
    {
        $this->excel->excelObj->getProperties()->setTitle($this->container->getParameter('site_name') . " Reseller listing")
            ->setSubject(" Reseller Listing")
            ->setDescription("A deatiled list of all Resellers loaded on " . $this->container->getParameter('site_name'))
            ->setKeywords("")
            ->setCategory("List");

        $fileName = 'reseller-list-' . date('Y-m-d') . '-' . sizeof($reseller) . '.xlsx';

        $this->resellerSheet($reseller, 0);
        
        //create the response
        $response = $this->excel->getResponse();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $fileName);

        // If you are using a https connection, you have to set those two headers for compatibility with IE <9
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;
    }

    /**
     * Excel artist list
     * 
     * @param array $artists
     * @return Response
     */
    public function artistList($artists)
    {
        $this->excel->excelObj->getProperties()->setTitle($this->container->getParameter('site_name') . " Artist listing")
            ->setSubject(" Artist Listing")
            ->setDescription("A deatiled list of all Artists loaded on " . $this->container->getParameter('site_name'))
            ->setKeywords("")
            ->setCategory("List");

        $fileName = 'artists-list-' . date('Y-m-d') . '-' . sizeof($artists) . '.xlsx';

        $this->artistSheet($artists, 0);
        
        //create the response
        $response = $this->excel->getResponse();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $fileName);

        // If you are using a https connection, you have to set those two headers for compatibility with IE <9
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;
    }

    /**
     * Excel pending song list
     * 
     * @param array $songs
     * @return Response
     */
    public function pendingSongList($songs)
    {
        $this->excel->excelObj->getProperties()->setTitle($this->container->getParameter('site_name') . " Pending songs listing")
            ->setSubject(" Pending songs Listing")
            ->setDescription("A deatiled list of all pending songs loaded on " . $this->container->getParameter('site_name'))
            ->setKeywords("")
            ->setCategory("List");

        $fileName = 'pending-songs-list-' . date('Y-m-d') . '-' . sizeof($songs) . '.xlsx';

        $this->pendingSongSheet($songs, 0);
        
        //create the response
        $response = $this->excel->getResponse();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $fileName);

        // If you are using a https connection, you have to set those two headers for compatibility with IE <9
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;
    }
    

    /**
     * Excel active song list
     * 
     * @param array $songs
     * @return Response
     */
    public function activeSongList($songs)
    {
        $this->excel->excelObj->getProperties()->setTitle($this->container->getParameter('site_name') . " Active songs listing")
            ->setSubject(" Active songs Listing")
            ->setDescription("A deatiled list of all active songs loaded on " . $this->container->getParameter('site_name'))
            ->setKeywords("")
            ->setCategory("List");

        $fileName = 'active-songs-list-' . date('Y-m-d') . '-' . sizeof($songs) . '.xlsx';

        $this->activeSongSheet($songs, 0);
        
        //create the response
        $response = $this->excel->getResponse();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $fileName);

        // If you are using a https connection, you have to set those two headers for compatibility with IE <9
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;
    }    
    

    /**
     * Excel codes list
     * 
     * @param array $codes
     * @return Response
     */
    public function codesList($codes)
    {
        $this->excel->excelObj->getProperties()->setTitle($this->container->getParameter('site_name') . " Codes listing")
            ->setSubject(" Codes Listing")
            ->setDescription("A deatiled list of all codes loaded on " . $this->container->getParameter('site_name'))
            ->setKeywords("")
            ->setCategory("List");

        $fileName = 'codes-list-' . date('Y-m-d') . '-' . sizeof($codes) . '.xlsx';

        $this->codesSheet($codes, 0);
        
        //create the response
        $response = $this->excel->getResponse();
        $response->headers->set('Content-Type', 'application/vnd.ms-excel; charset=utf-8');
        $response->headers->set('Content-Disposition', 'attachment;filename=' . $fileName);

        // If you are using a https connection, you have to set those two headers for compatibility with IE <9
        $response->headers->set('Pragma', 'public');
        $response->headers->set('Cache-Control', 'maxage=1');
        return $response;
    }    

}