<?php

namespace App\Controller;

use App\Entity\Package;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Workflow\Exception\ExceptionInterface;
use Symfony\Component\Workflow\Registry;

#[Route('/package')]
class PackageController extends AbstractController
{
    public function __construct(private Registry $registry)
    {
    }

    #[Route('/show/package/{id}', name: 'show-package')]
    public function packageShow(Package $package): Response
    {
        return $this->render('package/package.html.twig', [
            'package' => $package,
        ]);
    }

    #[Route('/apply-transition/{id}', name: 'package-apply-transition')]
    public function applyTransition(Request $request, Package $package): RedirectResponse
    {
        try {
            $this->getCurrentWorkflow($package)->apply($package, $request->request->get('transition'));
            $this->getDoctrine()->getManager()->flush();
        } catch (ExceptionInterface $e) {
            $this->addFlash('danger', $e->getMessage());
        }

        return $this->redirect(
            $this->generateUrl('show-package', ['id' => $package->getId()])
        );
    }

    #[Route('/reset-current-place/{id}', name: 'reset-current-place')]
    public function resetCurrentPlace(Package $package): RedirectResponse
    {
        $package->setCurrentPlace('import');
        $this->getDoctrine()->getManager()->flush();
        $this->addFlash('warning', 'Place was changed to import');

        return $this->redirect(
            $this->generateUrl('show-package', ['id' => $package->getId()])
        );

    }

    private function getCurrentWorkflow(Package $package)
    {
        return $this->registry->get($package);
    }


}
