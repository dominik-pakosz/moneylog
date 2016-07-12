<?php

namespace InfinitySystems\CalcBundle\Controller;

use InfinitySystems\CalcBundle\Entity\Money;
use InfinitySystems\CalcBundle\Form\MoneyForm;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CalcController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @return Response
     */
    public function indexAction()
    {
        $monthsSum = $this->getDoctrine()->getRepository('CalcBundle:Money')->sumAllMonths();
        $unitSum = $this->getDoctrine()->getRepository('CalcBundle:Money')->sumAllUnits();

        return $this->render('index.html.twig', [
            'monthsSum' => $monthsSum,
            'units' => $unitSum
        ]);
    }
    
    /**
     * @Route("/add", name="add_money")
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $form = $this->createForm(MoneyForm::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $money = $form->getData();
            $money->setAddDate(new \DateTime('now'));


            $em = $this->getDoctrine()->getManager();
            $em->persist($money);
            $em->flush();

            $this->addFlash('success', 'Dodano do bazy danych!');

            return $this->redirectToRoute('homepage');
        }

        return $this->render('add.html.twig',[
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("/delete/{id}", name="delete")
     * @param Money $money
     * @return Response
     */
    public function deleteAction(Money $money)
    {
        if(!$money) {
            throw $this->createNotFoundException('Nie znaleziono obiektu!');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($money);
        $em->flush();

        $this->addFlash('success', 'Usunięto z bazy!');

        return $this->redirectToRoute('homepage');
    }

    /**
     * @Route("/{month}", name="month_bilans")
     * @param string $month
     * @return Response
     */
    public function monthAction($month)
    {
        $monthBalance = $this->getDoctrine()->getRepository('CalcBundle:Money')->getAllInMonth($month);

        if (!$monthBalance) {
            throw $this->createNotFoundException('Nie znaleziono takiego miesiąca!');
        }
        
        $monthSum = $this->getDoctrine()->getRepository('CalcBundle:Money')->sumInMonth($month);
        
        return $this->render('month.html.twig', [
            'balance' => $monthBalance,
            'sum' => $monthSum
        ]);

    }
}
