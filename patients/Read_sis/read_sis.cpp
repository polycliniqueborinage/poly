#ifndef __SISPUBLIC_H__
#define __SISPUBLIC_H__

/*!
*
* \file SisPublic.h
* \brief SIS public info library
*
* Library for reading public info from the SIS card
*
* \author Serge Koganovitsch
* \note Copyright (C) 2005 Zetes PASS
*
*/

#ifdef __cplusplus
extern "C" {
#endif

#ifdef WIN32
#include <winscard.h>

#ifdef SISPUBLIC_EXPORTS
#define SISPUBLIC_API __declspec(dllexport)
#else
#define SISPUBLIC_API __declspec(dllimport)
#endif

#else
#include <pcsclite.h>

#define SISPUBLIC_API
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

/*! Public Data File
*
*/
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

/*! \brief Read the relevant 404 bytes from the SIS card
*
* This function reads the complete relevant content (404 bytes) of
the SIS card and copies the raw content in the buffer.
* This function returns PC/SC return codes. Depending on the OS
winscard.h or pcsclite.h are included to
* make sure the return codes are properly defined.
*
* Card readers: this function will try to read a SIS card in the
first available (according to PC/SC card reader enumeration), supported
card reader.
* Check the product documentation for a list of supported card
readers.
*
* \param pucBuffer the buffer (SIS_LEN bytes) where the SIS card will
be stored
*
* \return PC/SC error code
* \return SCARD_S_SUCCESS if ok
* \return SCARD_E_INSUFFICIENT_BUFFER if pucBuffer is NULL
*
*/
SISPUBLIC_API LONG SisPublicReadCard(unsigned char *pucBuffer);

/*! \brief Extract the public data files from a SIS image and parse
the content.
*
* This function will extract the two public files - the PBDF (Public
Data File) and the
* ISDF (Issuer Data File) - from the SIS image. PBDF and ISDF are
parsed and the relevant
* data fields are made available in 2 data structures, resp. of type
Pbdf and Isdf.
*
* \param pucBuffer the buffer (SIS_LEN bytes) containing the SIS
card image read
* \param pxPbdf the resulting PBDF file
* \param pxIsdf the resulting ISDF file
*
* \note dates are always in "YYYYMMDD" format
*
* \return ERR_OK if ok
* \return ERR_PARAM if parameter error
* \return ERR_BNCS if SIS parse error
* \return ERR_INTERNAL if internal error
*
*/
SISPUBLIC_API SisPublicError SisPublicParse(const unsigned char
*pucBuffer, Pbdf *pxPbdf, Isdf *pxIsdf);

#ifdef __cplusplus
}
#endif

#endif



//------------------------------------------------------------------------------


#include "SisPublic.h"
#include <stdio.h>
#include <winscard.h>

//================================================== ===================
//
// function prototypes
//
//================================================== ===================

char *GetScardErrMsg(int code);
void Dump(const Pbdf *, const Isdf *);

//================================================== ===================
//
// main function
//
//================================================== ===================
int main(int argc, char **argv)
{
long lReturn;
char sis[SIS_LEN];
Pbdf pbdf;
Isdf isdf;

printf("reading SIS card ...\n");
if (SCARD_S_SUCCESS != (lReturn = SisPublicReadCard(sis)))
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
}

return 0;
}

//================================================== ===================
//
// Dump
//
//================================================== ===================
void Dump(const Pbdf *pPbdf, const Isdf *pIsdf)
{
printf("\n");

printf("Contents of PBDF:\n");
printf("-----------------\n");
printf("File Identification Number: %s\n", pPbdf->FIDN);
printf("File Secret Key Index: %s\n", pPbdf->FSKI);
printf("Social Security Identification Number: %s\n", pPbdf->SSIN);
printf("Data Capture Date: %s\n", pPbdf->DCDT);
printf("Holder's Firstname: %s\n", pPbdf->NAME);
printf("Holder's Surname: %s\n", pPbdf->SNME);
printf("Holder's Initial: %s\n", pPbdf->INIT);
printf("Holder's Sex: %s\n", pPbdf->SEXE);
printf("Holder's Birthdate: %s\n", pPbdf->BRDT);
printf("File Certificate: %s\n", pPbdf->FCTF);
printf("File Checksum: %s\n", pPbdf->FCSM);

printf("\n");
printf("Contents of ISDF:\n");
printf("-----------------\n");
printf("File Identification Number: %s\n", pIsdf->FIDN);
printf("File Secret Key Index: %s\n", pIsdf->FSKI);
printf("Social Security Identification Number: %s\n", pIsdf->SSIN);
printf("Data Capture Date: %s\n", pIsdf->DCDT);
printf("Card Name: %s\n", pIsdf->CNME);
printf("Card Language: %s\n", pIsdf->CLAN);
printf("Card Logical Number: %s\n", pIsdf->CLGN);
printf("Card Begin Date: %s\n", pIsdf->CBDT);
printf("Card End Date: %s\n", pIsdf->CEDT);
printf("File Certificate: %s\n", pIsdf->FCTF);
printf("File Checksum: %s\n", pIsdf->FCSM);
}

//================================================== ===================
//
// GetScardErrMsg
//
//================================================== ===================
char *GetScardErrMsg(int code)
{
switch(code)
{
// Smartcard Reader interface errors
case SCARD_E_CANCELLED:
return "The action was canceled by an SCardCancel request.";
case SCARD_E_CANT_DISPOSE:
return "The system could not dispose of the media in the requested manner.";
case SCARD_E_CARD_UNSUPPORTED:
return "The smart card does not meet minimal requirements for support.";
case SCARD_E_DUPLICATE_READER:
return "The reader driver didn't produce a unique reader name.";
case SCARD_E_INSUFFICIENT_BUFFER:
return "The data buffer for returned data is too small for the returned data.";
case SCARD_E_INVALID_ATR:
return "An ATR string obtained from the registry is not a valid ATR string.";
case SCARD_E_INVALID_HANDLE:
return "The supplied handle was invalid.";
case SCARD_E_INVALID_PARAMETER:
return "One or more of the supplied parameters could not be properly interpreted.";
case SCARD_E_INVALID_TARGET:
return "Registry startup information is missing or invalid.";
case SCARD_E_INVALID_VALUE:
return "One or more of the supplied parameter values could not be properly interpreted.";
case SCARD_E_NOT_READY:
return "The reader or card is not ready to accept commands.";
case SCARD_E_NOT_TRANSACTED:
return "An attempt was made to end a non-existent transaction.";
case SCARD_E_NO_MEMORY:
return "Not enough memory available to complete this command.";
case SCARD_E_NO_SERVICE:
return "The smart card resource manager is not running.";
case SCARD_E_NO_SMARTCARD:
return "The operation requires a smart card, but no smart card is currently in the device.";
case SCARD_E_PCI_TOO_SMALL:
return "The PCI receive buffer was too small.";
case SCARD_E_PROTO_MISMATCH:
return "The requested protocols are incompatible with the protocol currently in use with the card.";
case SCARD_E_READER_UNAVAILABLE:
return "The specified reader is not currently available for use.";
case SCARD_E_READER_UNSUPPORTED:
return "The reader driver does not meet minimal requirements for support.";
case SCARD_E_SERVICE_STOPPED:
return "The smart card resource manager has shut down.";
case SCARD_E_SHARING_VIOLATION:
return "The smart card cannot be accessed because of other outstanding connections.";
case SCARD_E_SYSTEM_CANCELLED:
return "The action was canceled by the system, presumably to log off or shut down.";
case SCARD_E_TIMEOUT:
return "The user-specified timeout value has expired.";
case SCARD_E_UNKNOWN_CARD:
return "The specified smart card name is not recognized.";
case SCARD_E_UNKNOWN_READER:
return "The specified reader name is not recognized.";
case SCARD_F_COMM_ERROR:
return "An internal communications error has been detected.";
case SCARD_F_INTERNAL_ERROR:
return "An internal consistency check failed.";
case SCARD_F_UNKNOWN_ERROR:
return "An internal error has been detected, but the source is unknown.";
case SCARD_F_WAITED_TOO_LONG:
return "An internal consistency timer has expired.";
case SCARD_W_REMOVED_CARD:
return "The smart card has been removed and no further communication is possible.";
case SCARD_W_RESET_CARD:
return "The smart card has been reset, so any shared state information is invalid.";
case SCARD_W_UNPOWERED_CARD:
return "Power has been removed from the smart card and no further communication is possible.";
case SCARD_W_UNRESPONSIVE_CARD:
return "The smart card is not responding to a reset.";
case SCARD_W_UNSUPPORTED_CARD:
return "The reader cannot communicate with the card due to ATR string configuration conflicts.";
}

return "Error is not documented.";
}
