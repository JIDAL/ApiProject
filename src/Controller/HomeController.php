<?php


namespace App\Controller;


use App\Service\WeatherApiService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Swagger\Annotations as SWG;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationChecker;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Csrf\TokenStorage\TokenStorageInterface;


/**
 * Class HomeController
 * @package App\Controller
 *
 */
class HomeController extends AbstractController
{

    /**
     * @Route(path="/api/Weather", methods={"GET"})
     * @Security("is_granted('ROLE_ADMIN')")
     * @SWG\Get(
     *   tags={"Weather"},
     *   summary="get weather",
     *   description="returns weather by geographic coordinates",
     *   operationId="CreatePet",
     *   consumes={"application/json"},
     *   produces={"application/json"},
     * @SWG\Parameter(
     *   name="Authorization",
     *   in="header",
     *   type="string",
     *   required=true,
     *    description="Bearer auth"),
     *   @SWG\Parameter(name="latitude", in="query", type="string", description="latitude", required=true, default="48.63476"),
     *   @SWG\Parameter(name="longitude", in="query", type="string", description="longitude", required=true, default="2.54806"),
     *   @SWG\Response(response=200,description="Returns weather by geographic coordinates"),
     *   @SWG\Response(response=500, description="Invalid JWT Token")
     *   )
     * @param WeatherApiService $weather
     * @param string $lat
     * @param string $lon
     * @param TokenStorageInterface $tokenStorage
     * @param AuthorizationCheckerInterface $checker
     * @return JsonResponse
     */
    public function index(WeatherApiService $weather, string $lat="", string $lon="", TokenStorageInterface $tokenStorage, AuthorizationCheckerInterface $checker){
        $result = $weather->makeWeatherRequest($lat,$lon);
        return new JsonResponse($result);
    }

}