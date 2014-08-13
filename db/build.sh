PROPEL="../vendor/bin/propel"

$PROPEL reverse "mysql:host=localhost;dbname=justnyt;user=justnyt;password=justnyt" \
    --output-dir . \
    --database-name justnyt && \
    cat schema.xml | \
    sed -e 's/<table\(.*\)phpName="/<table\1namespace="justnyt\\models" phpName="/g'> schema.tmp && \
    mv schema.tmp schema.xml

$PROPEL convert-conf
$PROPEL model:build --output-dir ..

