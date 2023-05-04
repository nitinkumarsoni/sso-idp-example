<?php
require_once './config/config.php';


require_once './utility/IdpProvider.php';
require_once './utility/IdpTools.php';

// Initiating our IdP Provider connection.
$idpProvider = new IdpProvider();

// Instantiating our Utility class.
$idpTools = new IdpTools();


// Receive the HTTP Request and extract the SAMLRequest.
$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
echo '<pre>';
//print_r($request);
$saml_request = $idpTools->readSAMLRequest($request);

//die('Here');

// Getting a few details from the message like ID and Issuer.
$issuer = $saml_request->getMessage()->getIssuer()->getValue();
$id = $saml_request->getMessage()->getID();
//$issuer = 'https://www.michaelmanagement.com';
//echo $issuer;die;



// Simulate user information from IdP
$user_id = $request->get("username");
$user_email = 'er.json@example.com';
$firstName = 'John';
$lastName = 'Smith';

// Construct a SAML Response.
$response = $idpTools->createSAMLResponse($idpProvider, $user_id, $user_email,$firstName,$lastName, $issuer, $id);

try {

// Prepare the POST binding (form).
    $bindingFactory = new \LightSaml\Binding\BindingFactory();
    $postBinding = $bindingFactory->create(\LightSaml\SamlConstants::BINDING_SAML2_HTTP_POST);
    $messageContext = new \LightSaml\Context\Profile\MessageContext();
    $messageContext->setMessage($response);

// Ensure we include the RelayState.
  $message = $messageContext->getMessage();
  $message->setRelayState($request->get('RelayState'));
  $messageContext->setMessage($message);

// Return the Response.
    /** @var \Symfony\Component\HttpFoundation\Response $httpResponse */
    $httpResponse = $postBinding->send($messageContext);
    print $httpResponse->getContent();
} catch (Exception $exception){
    print_r($exception);
}