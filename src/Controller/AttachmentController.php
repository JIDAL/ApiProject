<?php


namespace App\Controller;

use App\DTO\ApiResponse;
use App\Entity\Attachment;
use App\Kernel;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Ramsey\Uuid\Uuid;

/**
 * Class AttachmentController
 * @package App\Controller
 * @Rest\Route("/api/cv")
 */
class AttachmentController extends AbstractFOSRestController
{
    /**
     * @SWG\Post(
     *     tags={"Resume"},
     *     description="Upload Attachments",
     *     consumes={"multipart/form-datachment"},
     *     @SWG\Parameter(
     *         name="attachment",
     *         in="formData",
     *         type="file",
     *         required=true,
     *         description="File",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Return Attachment",
     *     )
     * )
     *
     * @Rest\Post(path="/attachments", name="cv_attachments")
     * @Rest\View(serializerGroups={"all", "create"})
     *
     * @param Request $request
     * @param KernelInterface $kernel
     * @param EntityManagerInterface $em
     * @return View
     * @throws \Exception
     */
    public function uploadAttachment(Request $request, KernelInterface $kernel, EntityManagerInterface $em)
    {
        $imgDirectory = $kernel->getProjectDir() . '/public/uploads/images';
        $file = $request->files->get('attachment');
        if(!$file){
            return $this->view(null, ApiResponse::NOT_FOUND);
        }
            /**
             * @var UploadedFile $attachment
             */
            $imageFile = $file->move($imgDirectory, Uuid::uuid4()->toString() . '.' . $file->guessExtension());
            $attachment= new Attachment($imageFile->getBasename());
            $em->persist($attachment);
            $em->flush();
        return $this->view($attachment, ApiResponse::OK);
    }

}