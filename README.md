# Google-product-feed-xml
Build Google product feed xml in the Atom 1.0 format using the PHP DOMDocument class


Below is an example of a basic Atom 1.0 document containing a single item:

<?xml version="1.0"?>
<feed xmlns="http://www.w3.org/2005/Atom" xmlns:g="http://base.google.com/ns/1.0">
<title>Product Catalog feed</title>
<updated>2006-06-11T18:30:02Z</updated>
<entry>
  <g:id>25</g:id> 
  <g:description>25</g:description> 
  <g:link>http://bishalbudhapirthi.com</g:link> 
  <g:image_link>http://bishalbudhapirthi.com/image.jpg</g:image_link> 
  <g:condition>new</g:condition> 
  <g:availability>in stock</g:availability> 
  <g:google_product_category>tier1 > tier2 > tier 3</g:google_product_category> 
  <g:product_type>tier 1 > tier 2</g:product_type> 
  <shipping>
    <g:country>GB</g:country> 
    <g:service>Royal Mail</g:service> 
    <g:price>25.00 GB</g:price> 
  <shipping> 
  <g:gtin>5030578121109</g:gtin> 
  <g:brand>Bish</g:brand> 
</entry>
</feed>
