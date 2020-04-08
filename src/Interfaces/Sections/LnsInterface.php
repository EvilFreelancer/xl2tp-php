<?php

namespace XL2TP\Interfaces\Sections;

use XL2TP\Interfaces\SectionInterface;

/**
 * Interface GlobalInterface
 *
 * @package XL2TP\Interfaces\Sections
 * @since   1.0.0
 *
 * @property string $exclusive             If set to yes, only one control tunnel will be allowed to be built between 2 peers. CHECK
 * @property string $ipRange               Specify the range of ip addresses the LNS will assign to the connecting LAC PPP tunnels.
 * @property string $noIpRange             ^
 * @property string $assignIp              Set this to no if xl2tpd should not assign IP addresses out of the pool defined with the ip range option.
 * @property string $lac                   Specify the ip addresses of LAC's which are allowed to connect to xl2tpd acting as a LNS.
 * @property string $noLac                 ^
 * @property string $hiddenBit             If set to yes, xl2tpd will use the AVP hiding feature of L2TP.
 * @property string $localIp               Use the following IP as xl2tpd's own ip address.
 * @property string $lengthBit             If set to yes, the length bit present in the l2tp packet payload will be used.
 * @property string $requireChap           Will require or refuse the remote peer to get authenticated via CHAP for the ppp authentication.
 * @property string $refuseChap            ^
 * @property string $requirePap            Will require or refuse the remote peer to get authenticated via CHAP for the ppp authentication.
 * @property string $refusePap             ^
 * @property string $requireAuthentication Will require or refuse the remote peer to authenticate itself.
 * @property string $refuseAuthentication  ^
 * @property string $unixAuthentication    If set to yes, /etc/passwd will be used for remote peer ppp authentication.
 * @property string $hostname              Will report this as the xl2tpd hostname in negociation.
 * @property string $pppDebug              This will enable the debug for pppd.
 * @property string $pppoptfile            Specify the path for a file which contains pppd configuration parameters to be used.
 * @property string $callRws               This option is deprecated and no longer functions.
 * @property string $tunnelRws             This defines the window size of the control channel.
 * @property string $flowBits              If set to yes, sequence numbers will be included in the communication.
 * @property string $challenge             If set to yes, use challenge authentication to authenticate peer.
 * @property string $rxBps                 If set, the receive bandwidth maximum will be set to this value
 * @property string $txBps                 If set, the transmit bandwidth maximum will be set to this value
 */
interface LnsInterface extends SectionInterface
{
    /**
     * List of allowed parameters
     */
    public const ALLOWED = [
        'exclusive',
        'ip range',
        'no ip range',
        'assign ip',
        'lac',
        'no lac',
        'hidden bit',
        'local ip',
        'length bit',
        'require chap',
        'refuse chap',
        'require pap',
        'refuse pap',
        'require authentication',
        'refuse authentication',
        'unix authentication',
        'hostname',
        'ppp debug',
        'pppoptfile',
        'call rws',
        'tunnel rws',
        'flow bits',
        'challenge',
        'rx bps',
        'tx bps'
    ];
}
