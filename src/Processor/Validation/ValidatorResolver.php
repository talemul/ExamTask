<?php

namespace App\Processor\Validation;

use App\Model\DocumentInformation;
use App\Utils\DocumentTypeConstant;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Validator\Validation;

/**
 * Resolves validator and return corresponding vaildator class instance
 * against identity information country code
 * we can add more logic here if we need more country specific validation rules
 * return generic base validator if country specific validation is not needed
 */
class ValidatorResolver
{
    public static function resolveValidator(DocumentInformation $documentInformation)
    {
        // We support passport, identity card and residence permit documents in all countries.
        $allowedDocumentTypes = new AcceptedDocumentTypes([
            DocumentTypeConstant::PASSPORT,
            DocumentTypeConstant::IDENTITY_CARD,
            DocumentTypeConstant::RESIDENCE_PERMIT
        ]);

        // all documents expire 5 years after issue
        $expirePeriod = new ExpirePeriod(5);

        // all documents have document number consisting of 8 symbols
        $documentNumberLength = new DocumentNumberLength(8);

        $validator = Validation::createValidatorBuilder()
            ->getValidator();

        if ($documentInformation->getCountryCode() === "it") {
            // return Italian rules validator
            return new ItValidator($allowedDocumentTypes, $expirePeriod, $documentNumberLength, $validator);
        } elseif ($documentInformation->getCountryCode() === "es") {
            // return Spanish rules validator
            return new EsValidator($allowedDocumentTypes, $expirePeriod, $documentNumberLength, $validator);
        } elseif ($documentInformation->getCountryCode() === "uk") {
            // return United Kingdom rules validator
            return new UKValidator($allowedDocumentTypes, $expirePeriod, $documentNumberLength, $validator);
        } elseif ($documentInformation->getCountryCode() === "fr") {
            // return French rules validator and French accept drivers licence
            $allowedDocumentTypes = new AcceptedDocumentTypes([
                DocumentTypeConstant::PASSPORT,
                DocumentTypeConstant::IDENTITY_CARD,
                DocumentTypeConstant::RESIDENCE_PERMIT,
                DocumentTypeConstant::DRIVERS_LICENSE
            ]);

            return new FrValidator($allowedDocumentTypes, $expirePeriod, $documentNumberLength, $validator);
        } elseif ($documentInformation->getCountryCode() === "de") {
            // return German rules validator
            return new DeValidator($allowedDocumentTypes, $expirePeriod, $documentNumberLength, $validator);
        } elseif ($documentInformation->getCountryCode() === "pl") {
            // return Polish rules validator

            $allowedDocumentTypes = new AcceptedDocumentTypes([
                DocumentTypeConstant::PASSPORT,
                DocumentTypeConstant::IDENTITY_CARD
            ]);

            return new PlValidator($allowedDocumentTypes, $expirePeriod, $documentNumberLength, $validator);
        } else {
            // return generic validator
            return new DocumentValidator($allowedDocumentTypes, $expirePeriod, $documentNumberLength, $validator);
        }
    }
}
