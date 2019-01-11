<?php
/**
 * Class ProductFeed
 *
 * @version 1.0
 * @author  Bishal Budhapirthi <bishalbudhapirthi@gmail.com>
 * @created 2018-09-14
 */
class ProductFeed
{
    /**
     * @var string
     */
    private $namespace = 'http://base.google.com/ns/1.0';


    /**
     * @param $arrProducts
     */
    public function buildProductCatalogFeed($arrProducts)
    {

        $strXML = $this->buildXml($arrProducts);

    }

    /**
     * Build full product feed xml from list of prouducts
     *
     * @param $arrProducts
     */
    private function buildXml($arrProducts)
    {
        // Create the document.
        $objXmlRequest  = new \DOMDocument('1.0', 'utf-8');
        $objXmlRequest->formatOutput = true;
        $objRoot = $objXmlRequest->createElementNS('http://www.w3.org/2005/Atom', 'feed');
        $objRoot->setAttributeNS('http://www.w3.org/2000/xmlns/' ,'xmlns:g', $this->namespace);
        $objXmlRequest->appendChild($objRoot);

        // Set the xml title
        $objRoot->appendChild($objXmlRequest->createElement('title', 'Product Catalog Feed'));

        $objDateTime =  new \DateTime();

        $objRoot->appendChild($objXmlRequest->createElement('updated', $objDateTime->format('Y-m-d\TH:i:s\Z')));

        // Lets say not of the products are valid
        $blProductValid = false;

        foreach ($arrProducts as $arrProduct){

            // Skip those product that are not valid
            if ($this->hasFollowedGoogleProductSpecification($arrProduct)){
                continue;
            }


            $objEntryElement = $objXmlRequest->createElement('entry');

            $objRoot->appendChild($objEntryElement);

            $this->addEntryToFeed($objXmlRequest, $objEntryElement, $arrProduct);

            $blProductValid = true;
        }

        if (!$blProductValid){
            $this->errorMessage = "No products were valid in order to build xml file";
            return 400;
        }

        $objXmlRequest->appendChild($objRoot);

        $strXML = $objXmlRequest->saveXML();

        echo $strXML; // And here is your google product xml
    }

    /**
     * Build xml entry node for each product
     *
     * @param \DOMDocument $objXmlRequest
     * @param \DOMElement  $objEntryElement
     * @param              $arrProduct
     */
    private function addEntryToFeed(\DOMDocument $objXmlRequest, \DOMElement $objEntryElement, $arrProduct)
    {
        $objEntryElement->appendChild($objXmlRequest->createElementNS($this->namespace, 'g:id', $arrProduct['product code']));

        $title = $objEntryElement->appendChild($objXmlRequest->createElementNS($this->namespace, 'title'));

        $title->appendChild($objXmlRequest->createCDATASection($arrProduct['title']));

        $description = $objEntryElement->appendChild($objXmlRequest->createElementNS($this->namespace, 'description'));

        $description->appendChild($objXmlRequest->createCDATASection($arrProduct['product_description']));

        $objEntryElement->appendChild($objXmlRequest->createElementNS($this->namespace, 'g:link', 'https://bishalbudhapirthi.com/'));// landing page on your website for the advertised product

        $objEntryElement->appendChild($objXmlRequest->createElementNS($this->namespace, 'g:image_link', $arrProduct['image_link']));

        $objEntryElement->appendChild($objXmlRequest->createElementNS($this->namespace, 'g:condition', 'new'));

        $objEntryElement->appendChild($objXmlRequest->createElementNS($this->namespace, 'g:availability', 'in stock'));

        $objEntryElement->appendChild($objXmlRequest->createElementNS($this->namespace, 'g:price', $arrProduct['price'] .' GBP'));

        // Add google category tier level that is mapped to kondor tier 3
        $objEntryElement->appendChild($objXmlRequest->createElementNS($this->namespace, 'g:google_product_category', 'Put the google category mapped to your product code'));

        // Add shipping to each product
        $shippingXML = $objEntryElement->appendChild($objXmlRequest->createElementNS($this->namespace, 'shipping'));
        $shippingXML->appendChild($objXmlRequest->createElementNS($this->namespace, 'g:country', 'GB'));
        $shippingXML->appendChild($objXmlRequest->createElementNS($this->namespace, 'g:service', 'Royal Mail'));
        $shippingXML->appendChild($objXmlRequest->createElementNS($this->namespace, 'g:price', '0.00 GBP'));

        // Barcode
        $objEntryElement->appendChild($objXmlRequest->createElementNS($this->namespace, 'g:gtin', $arrProduct['barcode']));
        $objEntryElement->appendChild($objXmlRequest->createElementNS($this->namespace, 'g:brand', $arrProduct['brandname']));

    }

    /**
     * See google product specification for details
     *
     *  Visit : https://support.google.com/merchants/answer/7052112?visit_id=1-636524059048882077-3567403475&rd=1
     *
     *  I have assumed that all product has followed the google product specification
     *
     */
    private function hasFollowedGoogleProductSpecification($arrProduct)
    {
        return true;

    }
}
