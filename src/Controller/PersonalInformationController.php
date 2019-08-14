<?php


namespace App\Controller;

use App\DTO\ApiResponse;
use App\Entity\Attachment;
use App\Entity\PersonalInformation;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Exception\ValidatorException;
use App\Form\PersonalInformationType;

/**
 * Class PersonalInformationController
 * @package App\Controller
 * @Rest\Route("/api/cv")
 */
class PersonalInformationController extends AbstractFOSRestController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * PersonalInformationController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @Rest\Post(path="/presentation", name="presentation")
     * @SWG\Post(
     *     tags={"Resume"},
     *     description="add personal informations",
     *     @SWG\Parameter(
     *     name="Authorization",
     *     in="header",
     *     type="string",
     *     required=false,
     *     description="Bearer auth"),
     *     @SWG\Parameter(name="body", in="body", required=true, @SWG\Property(ref=@Model(type=PersonalInformationType::class, groups={"create"}))),
     *     @SWG\Response(response=204,description="")
     * )
     * @ParamConverter("information", converter="fos_rest.request_body", options={"validator"={"groups"={"create"}}} )
     * @Rest\View(serializerGroups={"create"})
     * @param Request $request
     * @param PersonalInformation $information
     * @param ConstraintViolationListInterface $violations
     * @return View
     */
    public function postPersonalInformation(Request $request,
                                            PersonalInformation $information,
                                            ConstraintViolationListInterface $violations){
        try{
            if (count($violations)) {
                throw  new ValidatorException();
            }
            $this->em->persist($information);
            $this->em->flush();
            $data = $information;
        }catch (ValidatorException $exception){
            return $this->view($violations, Response::HTTP_BAD_REQUEST);
        }
        return $this->view($data, ApiResponse::OK);

    }

    /**
     * @Rest\Put("/presentation/attachment/{id}")
     * @SWG\Put(
     *     tags={"Resume"},
     *     description="add personal photo",
     *     @SWG\Parameter(name="body", in="body", required=true, @SWG\Property(ref=@Model(type=Attachment::class, groups={"assign"}))),
     *     @SWG\Response(response=204,description="")
     * )
     * @ParamConverter("attachment", converter="fos_rest.request_body")
     * @Rest\View(serializerGroups={"all", "create", "show"})
     * @param Request $request
     * @param Attachment $attachment
     * @param PersonalInformation $presentation
     * @param ConstraintViolationListInterface $violations
     * @return View
     */
    public function putPersonalPhoto(Request $request, Attachment $attachment, PersonalInformation $presentation, ConstraintViolationListInterface $violations){
        // comment br
        try{
            if (count($violations)) {
                throw  new ValidatorException();
            }
            $attachment = $this->em->getRepository('App:Attachment')->find($attachment->getId());
            if(!$attachment){
                return $this->view([], ApiResponse::NOT_FOUND);
            }
            $presentation->setImage($attachment);
            $this->em->flush();
            $data = $presentation;
        }catch (ValidatorException $exception){
            return $this->view($violations, Response::HTTP_BAD_REQUEST);
        }
        return $this->view($data, ApiResponse::OK);

    }

}