#!/bin/bash

PPP_REMOTE="fe80::2de:faff:fe3a:100"
MAC1=$(echo $PPP_REMOTE | cut -d : -f 3)

let "c = $((16#$MAC1)) ^ 0x200"
printf "%x\n" c
