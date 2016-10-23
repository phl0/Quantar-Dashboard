# Quantar-Dashboard

This is the attempt to make a simple web interface showing basic information
pulled from a Quantar base station that is running for P25NX networks. The code
is meant to be running on the Raspberry Pi that is needed for P25NX networkking.

The Raspberry Pi is usually connected to the FastEthernet0/1 interface of the
cisco router with an IP address in the 172.31.x.x range. The Cisco router is
configured to allow telnet acces to some port that is routed to the AUX port.
The AUX port is connected to the console port of the Quantar with a selfmade
cable. The pinout can be found on http://p25.io/access-your-quantar-via-cisco/.

# Cisco router configuration

In my case it is a Cisco 2651XM router that is operating between Quantar and the
Raspberry Pi. The relevant part from the config is:

```
aaa authentication login NO_AUTHENTICATION none
aaa authorization exec NO_AUTHORIZATION none 
aaa authorization commands 15 NO_AUTHORIZATION none 

...

line aux 0
 exec-timeout 1 0
 authorization commands 15 NO_AUTHORIZATION
 authorization exec NO_AUTHORIZATION
 login authentication NO_AUTHENTICATION
 no exec
 transport input all
 transport output all
 stopbits 1
```

The aaa config is needed in order to disable authentication on the telnet port.
In order to not make this port available on the internet facing interface there
is an access-list bound to FastEthernet0/0 denying access to port 2065.
