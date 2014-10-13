<?php print("<?"); ?>xml version="1.0" encoding="UTF-8"<?php print("?>\n"); ?>
<rss version="2.0"
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:atom="http://www.w3.org/2005/Atom"
>
<channel>
    <title>JustNyt!</title>
    <link>http://<?= $host ?></link>
    <atom:link href="http://<?= $host ?>/feed/rss" rel="self" type="application/rss+xml" />
    <description>Parhautta - Just Nyt!</description>
    <?php foreach ($items as $item): ?>
        <item>
            <guid isPermaLink="true">http://<?= $host ?>/s/<?= $item->getShortLink() ?></guid>
            <pubDate><?= $item->getApprovedOn()->setTimezone(new DateTimeZone("UTC"))->format("D, d M Y H:i:s O") ?></pubDate>
            <title><?= $item->getTitle() ?></title>
            <link>http://<?= $host ?>/s/<?= $item->getShortLink() ?></link>
            <description><![CDATA[<?php if (null != $item->getQuote() && "" != $item->getQuote()): ?><blockquote><?= $item->getQuote() ?></blockquote><?php endif; ?>]]></description>
            <content:encoded><![CDATA[<?php if (null != $item->getQuote() && "" != $item->getQuote()): ?><blockquote><?= $item->getQuote() ?></blockquote><?php endif; ?>]]></content:encoded>
        </item>
    <?php endforeach; ?>
</channel>
</rss>

