<?php

namespace XL2TP\Interfaces\Sections;

use XL2TP\Interfaces\SectionInterface;

/**
 * Interface GlobalInterface
 *
 * @property string $authFile      Specify where to find the authentication file used to authenticate l2tp tunnels. The default is /etc/l2tpd/l2tp-secrets.
 * @property string $ipsecSaref    Use IPsec Security Association trackinng.
 * @property string $sarefRefinfo  When using IPsec Security Association trackinng, a new setsockopt is used.
 * @property string $listenAddr    The IP address of the interface on which the daemon listens. By default, it listens on INADDR_ANY (0.0.0.0), meaning it listens on all interfaces.
 * @property string $port          Specify which UDP port xl2tpd should use. The default is 1701.
 * @property string $accessControl If set to yes, the xl2tpd process will only accept connections from peers addresses specified in the following sections. The default is no.
 * @property string debugAvp       Set this to yes to enable syslog output of L2TP AVP debugging information.
 * @property string debugNetwork   Set this to yes to enable syslog output of network debugging information.
 * @property string debugPacket    Set this to yes to enable printing of L2TP packet debugging information. Note: Output goes to STDOUT, so use this only in conjunction with the -D command line option.
 * @property string debugState     Set this to yes to enable syslog output of FSM debugging information.
 * @property string debugTunnel    Set this to yes to enable syslog output of tunnel debugging information.
 */
interface GlobalInterface extends SectionInterface
{
    //
}
