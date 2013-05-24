/*
 * MUSCLE SmartCard Development ( http://www.linuxnet.com )
 *
 * Copyright (C) 1999-2004
 *  David Corcoran <corcoran@linuxnet.com>
 *  Ludovic Rousseau <ludovic.rousseau@free.fr>
 *
 * $Id: pcsclite.h.in 2375 2007-02-05 13:12:18Z rousseau $
*/
 
#ifndef __pcsclite_h__
#define __pcsclite_h__
 
#include <wintypes.h>

#ifdef __cplusplus
extern "C"
{
#endif
 
#ifdef WIN32
#include <winscard.h>
#else
typedef long SCARDCONTEXT;
typedef SCARDCONTEXT *PSCARDCONTEXT;
typedef SCARDCONTEXT *LPSCARDCONTEXT;
typedef long SCARDHANDLE;
typedef SCARDHANDLE *PSCARDHANDLE;
typedef SCARDHANDLE *LPSCARDHANDLE;
 
#define MAX_ATR_SIZE            33  
typedef struct
{
    const char *szReader;
    void *pvUserData;
    unsigned long dwCurrentState;
    unsigned long dwEventState;
    unsigned long cbAtr;
    unsigned char rgbAtr[MAX_ATR_SIZE];
}
SCARD_READERSTATE_A;
 
typedef SCARD_READERSTATE_A SCARD_READERSTATE, *PSCARD_READERSTATE_A,
    *LPSCARD_READERSTATE_A;
 
typedef struct _SCARD_IO_REQUEST
{
    unsigned long dwProtocol;   /* Protocol identifier */
    unsigned long cbPciLength;  /* Protocol Control Inf Length */
}
SCARD_IO_REQUEST, *PSCARD_IO_REQUEST, *LPSCARD_IO_REQUEST;
 
typedef const SCARD_IO_REQUEST *LPCSCARD_IO_REQUEST;

extern SCARD_IO_REQUEST g_rgSCardT0Pci, g_rgSCardT1Pci,
    g_rgSCardRawPci;
 
#define SCARD_PCI_T0    (&g_rgSCardT0Pci)
#define SCARD_PCI_T1    (&g_rgSCardT1Pci)
#define SCARD_PCI_RAW   (&g_rgSCardRawPci)
 
#define SCARD_S_SUCCESS         0x00000000
#define SCARD_F_INTERNAL_ERROR      0x80100001 
#define SCARD_E_CANCELLED       0x80100002 
#define SCARD_E_INVALID_HANDLE      0x80100003 
#define SCARD_E_INVALID_PARAMETER   0x80100004 
#define SCARD_E_INVALID_TARGET      0x80100005 
#define SCARD_E_NO_MEMORY       0x80100006 
#define SCARD_F_WAITED_TOO_LONG     0x80100007 
#define SCARD_E_INSUFFICIENT_BUFFER 0x80100008 
#define SCARD_E_UNKNOWN_READER      0x80100009 
#define SCARD_E_TIMEOUT         0x8010000A 
#define SCARD_E_SHARING_VIOLATION   0x8010000B 
#define SCARD_E_NO_SMARTCARD        0x8010000C 
#define SCARD_E_UNKNOWN_CARD        0x8010000D 
#define SCARD_E_CANT_DISPOSE        0x8010000E 
#define SCARD_E_PROTO_MISMATCH      0x8010000F 
#define SCARD_E_NOT_READY       0x80100010 
#define SCARD_E_INVALID_VALUE       0x80100011 
#define SCARD_E_SYSTEM_CANCELLED    0x80100012 
#define SCARD_F_COMM_ERROR      0x80100013 
#define SCARD_F_UNKNOWN_ERROR       0x80100014 
#define SCARD_E_INVALID_ATR     0x80100015 
#define SCARD_E_NOT_TRANSACTED      0x80100016 
#define SCARD_E_READER_UNAVAILABLE  0x80100017 
#define SCARD_W_UNSUPPORTED_CARD    0x80100065 
#define SCARD_W_UNRESPONSIVE_CARD   0x80100066 
#define SCARD_W_UNPOWERED_CARD      0x80100067 
#define SCARD_W_RESET_CARD      0x80100068 
#define SCARD_W_REMOVED_CARD        0x80100069 
#define SCARD_E_PCI_TOO_SMALL       0x80100019 
#define SCARD_E_READER_UNSUPPORTED  0x8010001A 
#define SCARD_E_DUPLICATE_READER    0x8010001B 
#define SCARD_E_CARD_UNSUPPORTED    0x8010001C 
#define SCARD_E_NO_SERVICE      0x8010001D 
#define SCARD_E_SERVICE_STOPPED     0x8010001E 
#define SCARD_E_NO_READERS_AVAILABLE    0x8010002E 
#define SCARD_SCOPE_USER        0x0000  
#define SCARD_SCOPE_TERMINAL        0x0001  
#define SCARD_SCOPE_SYSTEM      0x0002  
#define SCARD_PROTOCOL_UNSET        0x0000  
#define SCARD_PROTOCOL_T0       0x0001  
#define SCARD_PROTOCOL_T1       0x0002  
#define SCARD_PROTOCOL_RAW      0x0004  
#define SCARD_PROTOCOL_T15      0x0008  
#define SCARD_PROTOCOL_ANY      (SCARD_PROTOCOL_T0|SCARD_PROTOCOL_T1)   
#define SCARD_SHARE_EXCLUSIVE       0x0001  
#define SCARD_SHARE_SHARED      0x0002  
#define SCARD_SHARE_DIRECT      0x0003  
#define SCARD_LEAVE_CARD        0x0000  
#define SCARD_RESET_CARD        0x0001  
#define SCARD_UNPOWER_CARD      0x0002  
#define SCARD_EJECT_CARD        0x0003  
#define SCARD_UNKNOWN           0x0001  
#define SCARD_ABSENT            0x0002  
#define SCARD_PRESENT           0x0004  
#define SCARD_SWALLOWED         0x0008  
#define SCARD_POWERED           0x0010  
#define SCARD_NEGOTIABLE        0x0020  
#define SCARD_SPECIFIC          0x0040  
#define SCARD_STATE_UNAWARE     0x0000  
#define SCARD_STATE_IGNORE      0x0001  
#define SCARD_STATE_CHANGED     0x0002  
#define SCARD_STATE_UNKNOWN     0x0004  
#define SCARD_STATE_UNAVAILABLE     0x0008  
#define SCARD_STATE_EMPTY       0x0010  
#define SCARD_STATE_PRESENT     0x0020  
#define SCARD_STATE_ATRMATCH        0x0040  
#define SCARD_STATE_EXCLUSIVE       0x0080  
#define SCARD_STATE_INUSE       0x0100  
#define SCARD_STATE_MUTE        0x0200  
#define SCARD_STATE_UNPOWERED       0x0400  
#endif
 
#define SCARD_W_INSERTED_CARD       0x8010006A
#define SCARD_E_UNSUPPORTED_FEATURE 0x8010001F
 
#ifndef INFINITE
#define INFINITE            0xFFFFFFFF  
#endif
 
#define PCSCLITE_VERSION_NUMBER     "1.4.1" 
#define PCSCLITE_MAX_READERS_CONTEXTS           16
 
#define MAX_READERNAME          52
 
#ifndef SCARD_ATR_LENGTH
#define SCARD_ATR_LENGTH        MAX_ATR_SIZE    
#endif
 
/*
 * The message and buffer sizes must be multiples of 16.
 * The max message size must be at least large enough
 * to accomodate the transmit_struct
 */
#define MAX_BUFFER_SIZE         264 
#define MAX_BUFFER_SIZE_EXTENDED    (4 + 3 + (1<<16) + 3)   
/*
* Gets a stringified error response
*/
char *pcsc_stringify_error(long);

#ifdef __cplusplus
}
#endif

#endif
