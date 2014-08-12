<?php print("<?"); ?>xml version="1.0" encoding="UTF-8"<?php print("?>\n"); ?>
<rss version="2.0"
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:atom="http://www.w3.org/2005/Atom"
>
<channel>
    <title>JustNyt!</title>
    <link>http://justnyt.fi</link>
    <atom:link href="http://<?= $host ?>/feed/rss" rel="self" type="application/rss+xml" />
    <description>Parhautta - Just Nyt!</description>
    <?php foreach ($items as $item): ?>
        <item>
            <guid isPermaLink="true">http://justnyt.fi/s/<?= $item->getShortLink() ?></guid>
            <pubDate><?= $item->getApprovedOn()->setTimezone(new DateTimeZone("UTC"))->format("D, d M Y H:i:s O") ?></pubDate>
            <title><?= $item->getTitle() ?></title>
            <link><?= $item->getUrl() ?></link>
            <description>
            <![CDATA[
                <?= $item->getTitle() . PHP_EOL ?>
                <?= $item->getUrl() . PHP_EOL ?>
            ]]>
            </description>
            <content:encoded>
            <![CDATA[
                <?= $item->getTitle() . PHP_EOL ?>
                <?= $item->getUrl() . PHP_EOL ?>
            ]]>
            </content:encoded>
        </item>
    <?php endforeach; ?>
</channel>
</rss>

