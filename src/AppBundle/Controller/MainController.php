<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\User;
use AppBundle\Entity\Download;
use AppBundle\Entity\File;
use AppBundle\Entity\Course;

class MainController extends Controller
{
    /**
     * @Route("/", name="main")
     */
    public function indexAction(Request $request)
    {
        return $this->render('main/index.html.twig', array());
    }

    public function statsAction() {
        $todayBeginDate = new \DateTime('today');
        $todayEndDate = new \DateTime('today');
        $todayEndDate->setTime(23,59,59);
        $thisMonthBeginDate = new \DateTime('first day of this month');
        $thisMonthBeginDate->setTime(0,0,0);
        $thisMonthEndDate = new \DateTime('last day of this month');
        $thisMonthEndDate->setTime(23,59,59);
        $thisYearBeginDate = new \DateTime('first day of January this year');
        $thisYearBeginDate->setTime(0,0,0);
        $thisYearEndDate = new \DateTime('last day of December this year');
        $thisYearEndDate->setTime(23,59,59);
        $userRepository = $this
            ->getDoctrine()
            ->getRepository(User::class);
        $stats['userCount'] = \count($userRepository->findAll());
        $downloadRepository = $this
            ->getDoctrine()
            ->getRepository(Download::class);
        $stats['allDownloads'] = \count($downloadRepository->findAll());
        $stats['todayDownloads'] = \count($downloadRepository->createQueryBuilder('D')
            ->where('D.time > :todayBeginDate')
            ->andWhere('D.time < :todayEndDate')
            ->setParameter('todayBeginDate', $todayBeginDate)
            ->setParameter('todayEndDate', $todayEndDate)
            ->getQuery()->getResult());
        $stats['monthDownloads'] = \count($downloadRepository->createQueryBuilder('D')
            ->where('D.time > :thisMonthBeginDate')
            ->andWhere('D.time < :thisMonthEndDate')
            ->setParameter('thisMonthBeginDate', $thisMonthBeginDate)
            ->setParameter('thisMonthEndDate', $thisMonthEndDate)
            ->getQuery()->getResult());
        $stats['yearDownloads'] = \count($downloadRepository->createQueryBuilder('D')
            ->where('D.time > :thisYearBeginDate')
            ->andWhere('D.time < :thisYearEndDate')
            ->setParameter('thisYearBeginDate', $thisYearBeginDate)
            ->setParameter('thisYearEndDate', $thisYearEndDate)
            ->getQuery()->getResult());
        $fileRepository = $this->getDoctrine()->getRepository(File::class);
        $stats['allFiles'] = \count($fileRepository->findAll());
        $courseRepository = $this->getDoctrine()->getRepository(Course::class);
        $stats['allCourses'] = \count($courseRepository->findAll());
        return $this->render('main/stats.html.twig',array('stats' => $stats));
    }

}
