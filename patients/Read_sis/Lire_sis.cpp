//#include "SisPublic.h"
#include <stdio.h>
#include <windows.h>
//#include <winscard.h>


#ifdef SISPUBLIC_EXPORTS
#define SISPUBLIC_API __declspec(dllexport)
#else
#define SISPUBLIC_API __declspec(dllimport)
#endif


#define SIS_LEN 404
#define BCDDATE_LEN (8+1)
#define FIDN_LEN (4+1)
#define FSKI_LEN (2+1)
#define FCTF_LEN (8+1)
#define FCSM_LEN (2+1)
#define PBDF_NAME_LEN (48+1)
#define PBDF_SNME_LEN (24+1)
#define PBDF_SSIN_LEN (11+1)
#define PBDF_INIT_LEN (1+1)
#define PBDF_SEXE_LEN (1+1)
#define ISDF_SSIN_LEN PBDF_SSIN_LEN
#define ISDF_CNME_LEN (10+1)
#define ISDF_CLAN_LEN (1+1)
#define ISDF_CLGN_LEN (10+1)

#define FRANC_SOC_LEN 4
#define REG_TIERSP_LEN 1
#define ORG_ASSUR_LEN 2
#define ID_ORG_ASSUR_LEN 13
#define CT1_LEN 3
#define CT2_LEN 3
#define BEGDA_LEN 3
#define ENDDA_LEN 3

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


typedef struct
{
unsigned char FIDN[FIDN_LEN]; //!< File Identification Number(0012)
unsigned char FSKI[FSKI_LEN]; //!< File Secret Key Index
unsigned char SSIN[PBDF_SSIN_LEN]; //!< Social Security Identification Number
unsigned char DCDT[BCDDATE_LEN]; //!< Data Capture Date
unsigned char NAME[PBDF_NAME_LEN]; //!< Holder's Firstname
unsigned char SNME[PBDF_SNME_LEN]; //!< Holder's Surname
unsigned char INIT[PBDF_INIT_LEN]; //!< Holder's initial
unsigned char SEXE[PBDF_SEXE_LEN]; //!< Holder's Sex
unsigned char BRDT[BCDDATE_LEN]; //!< Holder's Birthdate
unsigned char FCTF[FCTF_LEN]; //!< File Certificate
unsigned char FCSM[FCSM_LEN]; //!< File Checksum
} Pbdf;

/*! Issuer Data File
*
*/
typedef struct
{
unsigned char FIDN[FIDN_LEN]; //!< File Identification Number
unsigned char FSKI[FSKI_LEN]; //!< File Secret Key Index
unsigned char SSIN[ISDF_SSIN_LEN]; //!< Social Security Identification Number
unsigned char DCDT[BCDDATE_LEN]; //!< Data Capture Date
unsigned char CNME[ISDF_CNME_LEN]; //!< Card Name
unsigned char CLAN[ISDF_CLAN_LEN]; //!< Card Language
unsigned char CLGN[ISDF_CLGN_LEN]; //!< Card Logical Number
unsigned char CBDT[BCDDATE_LEN]; //!< Card Begin Date
unsigned char CEDT[BCDDATE_LEN]; //!< Card End Date
unsigned char FCTF[FCTF_LEN]; //!< File Certificate
unsigned char FCSM[FCSM_LEN]; //!< File Checksum
} Isdf;

typedef struct
{
unsigned char FIDN[FIDN_LEN];                   //!< File Identification Number
unsigned char FSKI[FSKI_LEN];                   //!< File Secret Key Index
unsigned char CLGN[4];                          //!< Card Logical Number
unsigned char FSESAM[3];                        //!< File SESAM-OA
unsigned char FVER[7];                          //!< File Version Number
unsigned char FLAG[REG_TIERSP_LEN];             //!< Regime tiers payant
unsigned char INUMI1[ORG_ASSUR_LEN];            //!< Organisme assureur
unsigned char INID1[ID_ORG_ASSUR_LEN];          //!< ID organisme assureur
unsigned char ICT1_1[CT1_LEN];                  //!< CT1
unsigned char ICT2_1[CT2_LEN];                  //!< CT2
unsigned char IBDT_1[BEGDA_LEN];                //!< Date début
unsigned char IEDT_1[ENDDA_LEN];                //!< Date fin
unsigned char INUMI2[ORG_ASSUR_LEN];            //!< Organisme assureur
unsigned char INID2[ID_ORG_ASSUR_LEN];          //!< ID organisme assureur
unsigned char ICT1_2[CT1_LEN];                  //!< CT1
unsigned char ICT2_2[CT2_LEN];                  //!< CT2
unsigned char IBDT_2[BEGDA_LEN];                //!< Date début
unsigned char IEDT_2[ENDDA_LEN];                //!< Date fin
unsigned char INUMI3[ORG_ASSUR_LEN];            //!< Organisme assureur
unsigned char INID3[ID_ORG_ASSUR_LEN];          //!< ID organisme assureur
unsigned char ICT1_3[CT1_LEN];                  //!< CT1
unsigned char ICT2_3[CT2_LEN];                  //!< CT2
unsigned char IBDT_3[BEGDA_LEN] ;               //!< Date début
unsigned char IRDT_3[ENDDA_LEN] ;               //!< Date fin
unsigned char FCTF[FCTF_LEN];                   //!< File Certificate
unsigned char FCSM[FCSM_LEN];                   //!< File Checksum
} Sfdf;

/*! Error codes for SisPublicParse function
*
*/
typedef enum
{
ERR_OK = 0, //!< No error
ERR_PARAM = 1, //!< Parameter error
ERR_BNCS = 2, //!< BNCS error
ERR_INTERNAL = 3 //!< Internal error
} SisPublicError;

SISPUBLIC_API LONG SisPublicReadCard(unsigned char *pucBuffer);

SISPUBLIC_API SisPublicError SisPublicParse(const unsigned char*pucBuffer, Pbdf *pxPbdf, Isdf *pxIsdf, Sfdf *pxSfdf);

typedef void (WINAPI * DLL_Function_ReadSis) (char sis[SIS_LEN]);
typedef void (WINAPI * DLL_Function_ParseSis) (char sis[SIS_LEN], Pbdf * pbdf, Isdf * isdf, Sfdf * sfdf);

int main(int argc, char **argv)
{
    //HMODULE hdll_winscard  = LoadLibrary("winscard.dll");
    HMODULE hdll_sispublic = LoadLibrary("SisPublic.dll");
    long         lReturn;
    char         sis[SIS_LEN];
    int          i;
    Pbdf         pbdf;
    Isdf         isdf;
    Sfdf         sfdf;

    DLL_Function_ReadSis pFuncReadSis;
    DLL_Function_ParseSis pFuncParseSis;
    pFuncReadSis = (DLL_Function_ReadSis) GetProcAddress( hdll_sispublic, "SisPublicReadCard" );
    pFuncParseSis = (DLL_Function_ParseSis) GetProcAddress( hdll_sispublic, "SisPublicParse" );
    
    printf("reading SIS card ...\n");
    pFuncReadSis(sis);
    pFuncParseSis(sis, &pbdf, &isdf, &sfdf);
    
    printf("Contents of PBDF:\n");
    printf("-----------------\n");
    printf("File Identification Number: %s\n", pbdf.FIDN);
    printf("File Secret Key Index: %s\n", pbdf.FSKI);
    printf("Social Security Identification Number: %s\n", pbdf.SSIN);
    printf("Data Capture Date: %s\n", pbdf.DCDT);
    printf("Holder's Firstname: %s\n", pbdf.NAME);
    printf("Holder's Surname: %s\n", pbdf.SNME);
    printf("Holder's Initial: %s\n", pbdf.INIT);
    printf("Holder's Sex: %s\n", pbdf.SEXE);
    printf("Holder's Birthdate: %s\n", pbdf.BRDT);
    printf("File Certificate: %s\n", pbdf.FCTF);
    printf("File Checksum: %s\n", pbdf.FCSM);
    
    printf("\n");
    printf("Contents of ISDF:\n");
    printf("-----------------\n");
    printf("File Identification Number: %s\n", isdf.FIDN);
    printf("File Secret Key Index: %s\n", isdf.FSKI);
    printf("Social Security Identification Number: %s\n", isdf.SSIN);
    printf("Data Capture Date: %s\n", isdf.DCDT);
    printf("Card Name: %s\n", isdf.CNME);
    printf("Card Language: %s\n", isdf.CLAN);
    printf("Card Logical Number: %s\n", isdf.CLGN);
    printf("Card Begin Date: %s\n", isdf.CBDT);
    printf("Card End Date: %s\n", isdf.CEDT);
    printf("File Certificate: %s\n", isdf.FCTF);
    printf("File Checksum: %s\n", isdf.FCSM);

    printf("\n\nCT1_1: %s\n", sfdf.FIDN);
    printf("\n\nCT2_1: %s\n", sfdf.FSKI);
    
    scanf("%d", &i);
    /*if (SCARD_S_SUCCESS != (lReturn = SisPublicReadCard(sis)))
    {
        printf("An error occurred: %lx\n", lReturn);
        printf("Error message: %s\n", GetScardErrMsg(lReturn));
    }
    else
    {
        //FILE *fp = fopen("c:/temp/sis.img", "wb");
        //fwrite(sis, 1, sizeof(sis), fp);
        //fclose(fp);
        SisPublicError err;
        if (ERR_OK == (err = SisPublicParse(sis, &pbdf, &isdf)))
        {
            Dump(&pbdf, &isdf);
        }
        else
        {
            printf("error: %d\n", err); // fixme: show error code ...
        }
    }*/
    
    //FreeLibrary(hdll_winscard);
    FreeLibrary(hdll_sispublic);
    
    return 0;
}          
