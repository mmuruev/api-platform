<?php
/**
 * Created by IntelliJ IDEA.
 * User: mf
 * Date: 28.03.17
 * Time: 1:52
 */

namespace AppBundle\Action;

use AppBundle\Entity\Client;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientData
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    /**
     * @Route(
     *     name="client_data",
     *     path="/client/{id}",
     *     defaults={"_api_resource_class"=Client::class, "_api_item_operation_name"="client_data"}
     * )
     * @Method("PUT")
     * @param Request $request
     * @param $data
     * @return mixed
     */
    public function __invoke(Request $request, $data) // API Platform retrieves the PHP entity using the data provider then (for POST and
                                    // PUT method) deserializes user data in it. Then passes it to the action. Here $data
                                    // is an instance of Book having the given ID. By convention, the action's parameter
                                    // must be called $data.
    {
       //var_dump($request->attributes->all(),$data);
        //$this->client->doSomething($data);

        return $data; // API Platform will automatically validate, persist (if you use Doctrine) and serialize an entity
                      // for you. If you prefer to do it yourself, return an instance of Symfony\Component\HttpFoundation\Response
    }
}
