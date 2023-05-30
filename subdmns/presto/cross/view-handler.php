<?php
namespace Back\Cross;

require_once __DIR__ . '/config.php';

class ViewHandler {
    private $view, $id, $act;

    public function __construct($logged_in, $user_role, $url_view, $url_id, $url_act) {
        if ($logged_in) {
            if ($url_view) {
                $rqsted_view = Views::tryFrom(strtolower($url_view));
                
                if ($rqsted_view === null) {
                    $view = Views::Error;
                    $id = '404';
                } elseif ($rqsted_view === Views::Login) {
                    $view = Views::Error;
                    $id = '825';
                } else {
                    $rqsted_act = Acts::tryFromUrl($url_act);
                    $act = match(true) {
                        is_null($url_id) && is_null($rqsted_act) => Acts::Def,
                        !is_null($url_id) && is_null($rqsted_act) => Acts::Detail,
                        is_null($url_id) && ($rqsted_act === Acts::New) => Acts::New,
                        !is_null($url_id) && ($rqsted_act === Acts::Edit) => Acts::Edit
                    };
                    
                    if (in_array($act, $rqsted_view->acts())) {
                        // Authorized User
                        if (in_array($user_role, viewAuthRoles($rqsted_view, $act))) {
                            $view = $rqsted_view;
                            $id = $url_id;
                        } else {
                            $view = Views::Error;
                            $id = '403';
                            $act = null;
                        }
                    } else {
                        $view = Views::Error;
                        $id = '404';
                        $act = null;
                    }
                }
            } else {
                $view = Views::Home;
            }
        } else {
            if (isset($url_id) ||
                (isset($url_view) && strtolower($url_view) !== Views::Login->value)) {
                header('Location: /login');
            } else {
                $view = Views::Login;
            }
        }
        
        $this->view = $view;
        $this->id = $id ?? null;
        $this->act = $act ?? Acts::Def;
    }
    
    private function srcFilepath() {
        $view_section = $this->view->value;
        $act_section = match ($this->act) {
            Acts::Def => '',
            Acts::Detail => '-detail',
            Acts::New => '-new',
            Acts::Edit => '-edit',
        };
        
        return $view_section . $act_section;
    }

    public function viewFilepath() {
        $views_path = PATHS['views'] . '/';
        $filename = $this->srcFilepath();
        $ext = '.php';

        return $views_path . $filename . $ext;
    }

    public function cssFilepath() {
        $css_path = '/css/';
        $filename = $this->srcFilepath();
        $ext = '.css';

        return $css_path . $filename . $ext;
    }

    public function jsFilepath() {
        $js_path = '/js/';
        $filename = $this->srcFilepath();
        $ext = '.js';

        return $js_path . $filename . $ext;
    }

    public function getViewData(): array {
        return [
            'view' => $this->view,
            'id' => $this->id,
            'act' => $this->act
        ];
    }
}
