<?php


namespace App\Controller;

use App\Entity\Transaction;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use App\Form\TransactionFormType;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class TransactionController
 * @package App\Controller
 * @Rest\Route("/api")
 */
class TransactionController extends AbstractFOSRestController
{
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Rest\Post(path="/transaction", name="transaction")
     * @SWG\Response(
     *     response=204,
     *     description="",
     * )
     * @SWG\Parameter(
     *   name="Authorization",
     *   in="header",
     *   type="string",
     *   required=true,
     *    description="Bearer auth"),
     * @SWG\Parameter(name="body", in="body", required=true, @SWG\Property(ref=@Model(type=TransactionFormType::class))),
     * @ParamConverter("transaction", converter="fos_rest.request_body")
     * @SWG\Tag(name="Transaction")
     * @Rest\View()
     * @param ConstraintViolationListInterface $validationErrors
     * @param Transaction $transaction
     * @return View
     */
    public function postTransaction(ConstraintViolationListInterface $validationErrors, Transaction $transaction): View
    {
        try {
            if(count($validationErrors) != null){
                return View::create($validationErrors, Response::HTTP_BAD_REQUEST);
            }
            $this->em->persist($transaction);
            $this->em->flush();
            $data = $transaction;

        } catch (ValidatorException $e) {
            $statusCode = $e->getCode();
            $data = [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
            ];
        }
        return $this->view($data, Response::HTTP_OK);
    }

}