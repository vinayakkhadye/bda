<?php header ("Content-Type:text/xml"); ?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<?php echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">'; ?>
<?php if(is_array($url_data) && sizeof($url_data)>0 ){foreach($url_data as $key=>$url){ ?><url><loc><?=$url['url'];?></loc><lastmod><?=$url['lastmod'];?></lastmod><changefreq><?=$url['changefreq'];?></changefreq><priority><?=$url['priority'];?></priority></url><?php }}?>
<?php echo '</urlset>'; ?>