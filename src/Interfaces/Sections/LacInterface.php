<?php

declare(strict_types=1);

namespace XL2TP\Interfaces\Sections;

use XL2TP\Interfaces\SectionInterface;

/**
 * Interface GlobalInterface
 *
 * @package XL2TP\Interfaces\Sections
 * @since   1.0.0
 *
 * @property string $lns           Set the dns name or ip address of the LNS to connect to.
 * @property string $redial        If set to yes, xl2tpd will attempts to redial if the call get disconected.
 * @property string $redialTimeout Wait X seconds before redial. The redial option must be set to yes to use this option.
 * @property string $maxRedial     Will give up redial tries after X attempts.
 */
interface LacInterface extends SectionInterface
{
    /**
     * List of allowed parameters
     */
    public const ALLOWED = [
        'lns',
        'redial',
        'redial timeout',
        'max redial',
    ];
}
