<?php
/**
 * @author julienrajerison5@gmail.com jul
 *
 * Date : 08/08/2024
 */

namespace App\Twig;

use App\Repository\SiteContactRepository;
use Doctrine\DBAL\Exception;
use Twig\Extension\AbstractExtension;
use Twig\Extension\RuntimeExtensionInterface;
use Twig\TwigFunction;

class SiteMessageExtension extends AbstractExtension
{
    public function __construct(private SiteContactRepository $siteContactRepository)
    {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getMessageNotSeenCount', [$this, 'getMessageNotSeenCount']),
        ];
    }

    /**
     * @throws Exception
     */
    public function getMessageNotSeenCount(): int
    {
        return $this->siteContactRepository->findNotViewMessage();
    }
}