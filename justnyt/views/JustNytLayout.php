<?php
namespace justnyt\views;

class JustNytLayout
{
    /**
     * Oneliner shortcut for quickly rendering a View
     * @param string $template
     * @param array $data
     * @return string
     */
    static public function quickRender($template, $data = null) {
        $view = new \glue\ui\View($template);

        if (is_null($data)) {
            $data = array();
        } else if (! is_null($data) && is_array($data)) {
            $view->set($data);
        }

        $data["content"] = $view->render();

        if (isset($data["curator"]) && is_a($data["curator"], "\\justnyt\\models\\Curator")) {
            $pending = \justnyt\models\RecommendationQuery::create("rc")
                ->upcomingApproved()
                ->find();

            $data["pending"] = $pending->count();

            $hints = \justnyt\models\RecommendationHintQuery::create("rh")
                ->unreviewed()
                ->find();

            $data["hints"] = $hints->count();
        }

        return \glue\ui\View::quickRender(
            "layout", $data
            );
    }
}
