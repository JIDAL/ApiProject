<?php


namespace App\Controller;

use App\DTO\ApiResponse;
use App\Entity\User;
use App\Event\RegistrationEvent;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\Annotations as Rest;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Class SecurityController
 * @package App\Controller
 * @Rest\Route("/api/user")
 */
class SecurityController extends AbstractController
{
    /**
     * @var UserPasswordEncoderInterface;
     */
    private $encoder;
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var LoggerInterface
     */
    private $logger;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var JWTEncoderInterface
     */
    private $jwtEncoder;
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * SecurityController constructor.
     * @param EntityManagerInterface $em
     * @param UserPasswordEncoderInterface $encoder
     * @param LoggerInterface $logger
     * @param TokenStorageInterface $tokenStorage
     * @param EventDispatcherInterface $eventDispatcher
     */
    public function __construct(EntityManagerInterface $em,
                                UserPasswordEncoderInterface $encoder,
                                LoggerInterface $logger,
                                TokenStorageInterface $tokenStorage,
                                EventDispatcherInterface $eventDispatcher
                                )
    {
        $this->em = $em;
        $this->encoder = $encoder;
        $this->logger = $logger;
        $this->tokenStorage = $tokenStorage;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @SWG\Post(
     *     tags={"Authentication"},
     *     description="user registration",
     *     @SWG\Parameter(
     *        name="client",
     *        in="body",
     *        description="User object",
     *        required=true,
     *        @Model(type="App\Entity\User", groups={"client_account_creation"})
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="user created successfully"
     *     ),
     *     @SWG\Response(
     *     response=404,
     *     description="concession not found"
     *    ),
     *     @SWG\Response(
     *    response=500,
     *     description="server error"
     *    )
     *
     * )
     *
     * @Rest\Post(path="/account/creation", name="account_creation")
     * @ParamConverter(name="client", converter="fos_rest.request_body", options={"validator"={ "groups"={"client_account_creation"} }})
     *
     * @Rest\View()
     *
     *
     *
     * @param Request $request
     * @param User $client
     * @param ConstraintViolationListInterface $violations
     * @return ApiResponse
     */
    public function register(Request $request, User $client, ConstraintViolationListInterface $violations){
        try {
            $concession = $this->em->getRepository('App:Concession')->findOneBy(["name"=> $client->getConcession()->getName()]);
            if(!$concession){
                return new ApiResponse(null,ApiResponse::NOT_FOUND);
            }
            $user = new User();
            $user->setUsername($client->getUsername());
            $user->setConcession($concession);
            $user->setEmail($client->getEmail());
            $user->setPassword($this->encoder->encodePassword($user, $client->getPassword()));
            $this->em->persist($user);
            $this->em->flush();
            $this->eventDispatcher->dispatch(new RegistrationEvent($user), RegistrationEvent::NAME);

        } catch(Exception $exception) {

            $this->logger->error($exception->getMessage());
            throw $exception;
        }

        return new ApiResponse(null,ApiResponse::CREATED);
    }

    /**
     * @SWG\Post(
     *     tags={"Authentication"},
     *     description="Client phone number registration",
     *     @SWG\Parameter(
     *         name="Authorization",
     *         in="header",
     *         type="string",
     *         required=true,
     *         description="Basic auth",
     *     ),
     *     @SWG\Response(
     *         response=200,
     *         description="Return Jwt Token" ,
     *     ),
     *     @SWG\Response(
     *         response=407,
     *         description="Authentification failure"
     *
     *    ),
     *     @SWG\Response(
     *         response=500,
     *         description="Server error"
     *
     *    )
     * )
     *
     * @Rest\Post(name="login", path="/login")
     * @Rest\View()
     *
     * @return ApiResponse
     * @throws \Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTEncodeFailureException
     */

    public function login(){

        $user = $this->tokenStorage->getToken()->getUser();
        $token = 'Bearer ' . $this->jwtEncoder->encode(['username' => $user->getUsername()]);
        return $this->respondWith($token, ApiResponse::OK);

    }


}