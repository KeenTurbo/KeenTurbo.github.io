<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Wenming Tang <wenming@cshome.com>
 */
class UploadController extends Controller
{
    /**
     * @Route("/uploader/upload")
     * @Method("POST")
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     */
    public function uploadAction(Request $request)
    {
        $funcNum = $request->get('CKEditorFuncNum');

        return new Response(sprintf('<script type="text/javascript">
                                        window.parent.CKEDITOR.tools.callFunction(\'%s\', \'%s\');
                                     </script>',
            $funcNum,
            'https://www.baidu.com/img/bd_logo1.png'
        ));
    }
}