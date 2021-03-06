<?php

namespace App\Controller;

use App\Entity\ShortLink;
use App\Exception\DataLoaderException;
use App\Reports\Dto\GroupedByDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Reports\Factory\ReportFactoryInterface;
use Symfony\Component\Validator\Constraints\Url;
use Symfony\Component\Validator\Constraints\Length;
use App\ShortLink\Factory\ShortLinkFactoryInterface;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\ShortLink\UrlGenerator\ShortLinkUrlGeneratorInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DefaultController extends AbstractController
{
    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    /**
     * @var ShortLinkFactoryInterface
     */
    private ShortLinkFactoryInterface $shortLinkFactory;

    /**
     * @var ShortLinkUrlGeneratorInterface
     */
    private ShortLinkUrlGeneratorInterface $shortLinkUrlGenerator;

    /**
     * @var ReportFactoryInterface
     */
    private ReportFactoryInterface $reportFactory;

    /**
     * @param ValidatorInterface             $validator
     * @param ShortLinkFactoryInterface      $shortLinkFactory
     * @param ShortLinkUrlGeneratorInterface $shortLinkUrlGenerator
     * @param ReportFactoryInterface         $reportFactory
     */
    public function __construct(
        ValidatorInterface $validator,
        ShortLinkFactoryInterface $shortLinkFactory,
        ShortLinkUrlGeneratorInterface $shortLinkUrlGenerator,
        ReportFactoryInterface $reportFactory
    ) {
        $this->validator = $validator;
        $this->shortLinkFactory = $shortLinkFactory;
        $this->shortLinkUrlGenerator = $shortLinkUrlGenerator;
        $this->reportFactory = $reportFactory;
    }

    /**
     * @Route("/shortlink", name="app_create_shortlink", methods={"POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function shortLink(Request $request): Response
    {
        $shortLinkConstraints = [
            new NotBlank(), new Url(), new Length(null, null, 255)
        ];

        $violationList = $this->validator->validate(
            $request->request->get('url'),
            $shortLinkConstraints
        );

        if ($violationList->count()) {
            $errors = $this->prepareErrors($violationList);
            return $this->json(
                ['errors' => ['url' => $errors]],
                Response::HTTP_BAD_REQUEST
            );
        }

        $shortLink = $this->shortLinkFactory->create(
            $this->getUser(),
            $request->request->get('url'),
            true
        );

        return $this->json([
            'id' => $shortLink->getId(),
            'shortUrl' => $this->shortLinkUrlGenerator->generate($shortLink->getSlug())
        ]);
    }

    /**
     * @Route("/statistics", name="app_get_statistics", methods={"GET"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function statistics(Request $request): Response
    {
        $groupedByConstraints = [
            new NotBlank(null, 'This param should not be blank.')
        ];

        $violationList = $this->validator->validate(
            $request->query->get('groupedBy'),
            $groupedByConstraints
        );

        if ($violationList->count()) {
            $errors = $this->prepareErrors($violationList);
            return $this->json(
                ['errors' => ['groupedBy' => $errors]],
                Response::HTTP_BAD_REQUEST
            );
        }

        $groupedByParam = $request->query->get('groupedBy');

        if (!is_array($groupedByParam)) {
            $groupedByParam = [$groupedByParam];
        }

        try {
            $dto = new GroupedByDto($groupedByParam);
            $report = $this->reportFactory->create($dto);
        } catch (DataLoaderException $e) {
            return $this->json([
                'error' => $e->getMessage()],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json($report->convertToArray());
    }

    /**
     * @Route("/{slug}", name="app_resolve_shortlink", methods={"GET"})
     *
     * @param string $slug
     *
     * @return Response
     */
    public function resolve(string $slug): Response
    {
        /** @var ShortLink $shortLink */
        $shortLink = $this->getDoctrine()
            ->getRepository(ShortLink::class)
            ->findOneBy(['slug' => $slug]);

        if (!$shortLink) {
            return $this->json(['error' => 'url not found'], Response::HTTP_NOT_FOUND);
        }

        return $this->redirect($shortLink->getOriginal());
    }

    /**
     * @param ConstraintViolationListInterface $violationList
     *
     * @return array
     */
    private function prepareErrors(
        ConstraintViolationListInterface $violationList
    ): array {
        $errors = [];
        /** @var ConstraintViolation $violation */
        foreach ($violationList as $violation) {
            $errors[] = $violation->getMessage();
        }
        return $errors;
    }
}
