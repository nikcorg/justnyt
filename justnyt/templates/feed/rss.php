<?php print("<?"); ?>xml version="1.0" encoding="UTF-8"<?php print("?>\n"); ?>
<rss version="2.0"
        xmlns:content="http://purl.org/rss/1.0/modules/content/"
>
<channel>
    <title>JustNyt!</title>
    <link>http://justnyt.fi</link>
    <description>Parhautta - Just Nyt!</description>
    <?php foreach ($items as $item): ?>
        <item>
            <guid isPermaLink="true">http://justnyt.fi/s/<?= $item->getShortLink() ?></guid>
            <pubDate><?= $item->getApprovedOn()->setTimezone(new DateTimeZone("UTC"))->format("D, d M Y H:i:s T") ?></pubDate>
            <title><?= $item->getTitle() ?></title>
            <link><?= $item->getUrl() ?></link>
            <content:encoded>
            <![CDATA[
                <?= $item->getTitle() ?><?= PHP_EOL ?>
                <?= $item->getUrl() ?><?= PHP_EOL ?>
            ]]>
            </content:encoded>
            <description><?= $item->getTitle() ?></description>
        </item>
    <?php endforeach; ?>
</channel>
</rss>

