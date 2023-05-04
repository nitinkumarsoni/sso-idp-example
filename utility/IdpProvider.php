<?php
require_once(__DIR__ . '/../config/config.php');

class IdpProvider
{
// Defining some trusted Service Providers.
    private $ipId= 'https://www.michaelmanagement.com';
    private $trusted_sps = [
        'urn:service:provider:id' => 'https://auth.workos.com/sso/saml/acs/apPZe6kcdVDMgTi6hnDJM9KtJ',
    ];

    /**
     * Retrieves the Assertion Consumer Service.
     *
     * @param string
     *   The Service Provider Entity Id
     * @return
     *   The Assertion Consumer Service Url.
     */
    public function getServiceProviderAcs($entityId){
        //return $this->trusted_sps[$entityId];
        return 'https://auth.workos.com/sso/saml/acs/apPZe6kcdVDMgTi6hnDJM9KtJ';
    }

    /**
     * Returning a dummy IdP identifier.
     *
     * @return string
     */
    public function getIdPId(){
        return $this->ipId;
    }
    public function setIdPId($ipId){
        return $this->ipId = $ipId;
    }


    /**
     * Retrieves the certificate from the IdP.
     *
     * @return \LightSaml\Credential\X509Certificate
     */
    public function getCertificate(){
        return \LightSaml\Credential\X509Certificate::fromFile('cert/saml.crt');
    }

    /**
     * Retrieves the private key from the Idp.
     *
     * @return \RobRichards\XMLSecLibs\XMLSecurityKey
     */
    public function getPrivateKey(){
        return \LightSaml\Credential\KeyHelper::createPrivateKey('cert/saml.pem', '', true);
    }


}