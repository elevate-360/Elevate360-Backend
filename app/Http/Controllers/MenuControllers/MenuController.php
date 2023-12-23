<?php

namespace App\Http\Controllers\MenuControllers;

use Illuminate\Routing\Controller as BaseController;

class MenuController extends BaseController
{
    public function getMenu()
    {
        $return = '{
            "dashboard": {
                "id": "group-dashboard",
                "title": "dashboard",
                "type": "group",
                "icon": "dashboard",
                "children": [
                    {
                        "id": "dashboard",
                        "title": "dashboard",
                        "type": "collapse",
                        "icon": "dashboard",
                        "children": [
                            {
                                "id": "default",
                                "title": "default",
                                "type": "item",
                                "url": "/dashboard/default",
                                "breadcrumbs": false
                            },
                            {
                                "id": "analytics",
                                "title": "analytics",
                                "type": "item",
                                "url": "/dashboard/analytics",
                                "breadcrumbs": false
                            }
                        ]
                    },
                    {
                        "id": "components",
                        "title": "components",
                        "type": "item",
                        "url": "/components-overview/buttons",
                        "icon": "components",
                        "target": true,
                        "chip": {
                            "label": "new",
                            "color": "primary",
                            "size": "small",
                            "variant": "combined"
                        }
                    }
                ]
            },
            "company": {
                "id": "group-company",
                "title": "onboard company",
                "type": "group",
                "icon": "dashboard",
                "children": [
                    {
                        "id": "onboardCompany",
                        "title": "New Onboard Company",
                        "type": "item",
                        "url": "/company/onboard",
                        "icon": "components",
                        "target": false,
                        "chip": {
                            "label": "new",
                            "color": "primary",
                            "size": "small",
                            "variant": "combined"
                        }
                    },
                    {
                        "id": "blank",
                        "title": "blank page",
                        "type": "item",
                        "url": "/sample-page",
                        "icon": "chromeoutlined",
                        "target": false,
                        "chip": {
                            "label": "upgrade",
                            "color": "success",
                            "size": "small",
                            "variant": "combined"
                        }
                    }
                ]
            }
        }';
        return $return;
    }
}
