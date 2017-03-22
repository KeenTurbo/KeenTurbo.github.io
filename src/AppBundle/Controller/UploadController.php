<?php

namespace AppBundle\Controller;

use OSS\OssClient;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\UploadedFile;
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
     * @Security("is_granted('IS_AUTHENTICATED_REMEMBERED')")
     */
    public function uploadAction(Request $request)
    {
        $funcNum = $request->get('CKEditorFuncNum');

        /** @var UploadedFile $file */
        $file = $request->files->get('upload');

        try {
            if (null === $file || !$file->isValid()) {
                throw new \Exception('请选择要上传的文件');
            }

            if ($request->get('ckCsrfToken') !== $request->cookies->get('ckCsrfToken')) {
                throw new \Exception('请求不正确，请刷新页面后重试');
            }

            if (!in_array($file->getMimeType(), ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
                throw new \Exception('只能上传.png,.jpg,.gif格式文件');
            }

            if ($file->getSize() > 20480000) {
                throw new \Exception('文件大小不能超过 2MB');
            }

            $filename = sha1_file($file->getRealPath()) . '.' . $file->getClientOriginalExtension();
            $url = sprintf('%s/%s_b', $this->getParameter('oss_bucket1_url'), $filename);

            $ossClient = new OssClient($this->getParameter('oss_access_key_id'), $this->getParameter('oss_access_key_secret'), $this->getParameter('oss_end_point'));
            $ossClient->putObject($this->getParameter('oss_bucket1'), $filename, file_get_contents($file->getRealPath()));

            return new Response(sprintf('
                <script type="text/javascript">
                    window.parent.CKEDITOR.tools.callFunction(\'%s\', \'%s\');
                </script>',
                $funcNum,
                $url
            ));

        } catch (\Exception $e) {
            return new Response(sprintf('
                <script type="text/javascript">
                    window.parent.CKEDITOR.tools.callFunction(\'%s\', null, \'%s\');
                </script>',
                $funcNum,
                $e->getMessage()
            ));
        }
    }
}