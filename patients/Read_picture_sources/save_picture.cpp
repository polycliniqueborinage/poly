#include <stdio.h>
#include <stdlib.h>
#include <string.h>

#include "eidlib.h"

#if defined(_WIN32) || defined (__WIN32__)
#include <tchar.h>
#pragma comment( lib, "beidlib" )
#endif

#define PRINT( label_, data_ )    printf("%-25s: %s\n", label_, data_)
#if defined(_WIN32) || defined (__WIN32__)
#define PRINTU( label_, data_ )    _tprintf(_T("%-25s: %s\n"), label_, data_)
#else
#define _T
#define PRINTU( label_, data_ )    printf(_T("%-25s: %s\n"), label_, data_)
#endif

void PrintIDData(BEID_ID_Data *pData)
{
    PRINT("Card Number", pData->cardNumber);
    PRINT("Chip Number", pData->chipNumber);
    printf("%-25s: %s - %s\n", "Validity", pData->validityDateBegin, pData->validityDateEnd);
    PRINTU(_T("Delivery Municipality"), pData->municipality);
    PRINT("National Number", pData->nationalNumber);
    PRINTU(_T("Name"), pData->name);
    PRINTU(_T("First name 1"), pData->firstName1);
    PRINTU(_T("First name 2"), pData->firstName2);
    PRINTU(_T("First name 3"), pData->firstName3);
    PRINT("Nationality", pData->nationality);
    PRINTU(_T("Birthplace"), pData->birthLocation);
    PRINT("Birthdate", pData->birthDate);
    PRINT("Gender", pData->sex);
    PRINTU(_T("Noble Condition"), pData->nobleCondition);
    printf("%-25s: %d\n", "Document Type", pData->documentType);
    printf("Special Status: Whitecane: %s, Yellowcane: %s, Extendedminority: %s\n",  pData->whiteCane ? "TRUE" : "FALSE", 
            pData->yellowCane ? "TRUE" : "FALSE", pData->extendedMinority ? "TRUE" : "FALSE");
    printf("\n");
}

void PrintAddressData(BEID_Address *pData)
{
    PRINTU(_T("Street"), pData->street);
    PRINT("Number", pData->streetNumber);
    PRINT("Box", pData->boxNumber);
    PRINT("Zip", pData->zip);
    PRINTU(_T("Municipality"), pData->municipality);
    PRINT("Country", pData->country);
    printf("\n");
}


#define PRINTBYTES( label_, data_, length_ )    { printf("%-25s: ", label_ ); for (int i = 0; i < length_; i++) printf("%02X", data_[i]); printf("\n"); }
#define PRINTBYTE( label_, data_ )              printf("%-25s: %02X\n", label_ , data_);

void PrintVersionInfo(BEID_VersionInfo *pInfo)
{
    PRINTBYTES("Serial Number",  pInfo->SerialNumber, 16 );
    PRINTBYTE("ComponentCode", pInfo->ComponentCode);
    PRINTBYTE("OSNumber", pInfo->OSNumber);
    PRINTBYTE("OSVersion", pInfo->OSVersion);
    PRINTBYTE("SoftmaskNumber", pInfo->SoftmaskNumber);
    PRINTBYTE("SoftmaskVersion", pInfo->SoftmaskVersion);
    PRINTBYTE("AppletVersion", pInfo->AppletVersion);
    printf("%-25s: %d\n", "GlobalOSVersion", pInfo->GlobalOSVersion);
    PRINTBYTE("AppletInterfaceVersion", pInfo->AppletInterfaceVersion);
    PRINTBYTE("PKCS1Support", pInfo->PKCS1Support);
    PRINTBYTE("KeyExchangeVersion", pInfo->KeyExchangeVersion);
    PRINTBYTE("ApplicationLifeCycle", pInfo->ApplicationLifeCycle);
    PRINTBYTE("GraphPerso", pInfo->GraphPerso);
    PRINTBYTE("ElecPerso", pInfo->ElecPerso);
    PRINTBYTE("ElecPersoInterface", pInfo->ElecPersoInterface);
    printf("\n");
}


void PrintStatus( const char title[], BEID_Status tStatus )
{
    printf( "\n === %s ===\n", title );

    if ( BEID_OK == tStatus.general ) return;

    printf( " *** Return codes: general=%d, system=%d, PC/SC=%d, Card SW=%02X%02X\n",
            tStatus.general, tStatus.system, tStatus.pcsc, tStatus.cardSW[0], tStatus.cardSW[1]
          );

}

const char *VerifyCertErrorString(long n)
{
	switch ((int)n)
	{
	case BEID_CERTSTATUS_CERT_VALIDATED_OK:
		return("Valid");
	case BEID_CERTSTATUS_CERT_NOT_VALIDATED:
		return("Not validated");
	case BEID_CERTSTATUS_UNABLE_TO_GET_ISSUER_CERT:
		return("Unable to get issuer certificate");
	case BEID_CERTSTATUS_UNABLE_TO_GET_CRL:
		return("Unable to get certificate CRL");
	case BEID_CERTSTATUS_UNABLE_TO_DECRYPT_CERT_SIGNATURE:
		return("Unable to decrypt certificate's signature");
	case BEID_CERTSTATUS_UNABLE_TO_DECRYPT_CRL_SIGNATURE:
		return("Unable to decrypt CRL's signature");
	case BEID_CERTSTATUS_UNABLE_TO_DECODE_ISSUER_PUBLIC_KEY:
		return("Unable to decode issuer public key");
	case BEID_CERTSTATUS_CERT_SIGNATURE_FAILURE:
		return("Certificate signature failure");
	case BEID_CERTSTATUS_CRL_SIGNATURE_FAILURE:
		return("CRL signature failure");
	case BEID_CERTSTATUS_CERT_NOT_YET_VALID:
		return("Certificate is not yet valid");
	case BEID_CERTSTATUS_CRL_NOT_YET_VALID:
		return("CRL is not yet valid");
	case BEID_CERTSTATUS_CERT_HAS_EXPIRED:
		return("Certificate has expired");
	case BEID_CERTSTATUS_CRL_HAS_EXPIRED:
		return("CRL has expired");
	case BEID_CERTSTATUS_ERR_IN_CERT_NOT_BEFORE_FIELD:
		return("Format error in certificate's notBefore field");
	case BEID_CERTSTATUS_ERR_IN_CERT_NOT_AFTER_FIELD:
		return("Format error in certificate's notAfter field");
	case BEID_CERTSTATUS_ERR_IN_CRL_LAST_UPDATE_FIELD:
		return("Format error in CRL's lastUpdate field");
	case BEID_CERTSTATUS_ERR_IN_CRL_NEXT_UPDATE_FIELD:
		return("Format error in CRL's nextUpdate field");
	case BEID_CERTSTATUS_OUT_OF_MEM:
		return("Out of memory");
	case BEID_CERTSTATUS_DEPTH_ZERO_SELF_SIGNED_CERT:
		return("Self signed certificate");
	case BEID_CERTSTATUS_SELF_SIGNED_CERT_IN_CHAIN:
		return("Self signed certificate in certificate chain");
	case BEID_CERTSTATUS_UNABLE_TO_GET_ISSUER_CERT_LOCALLY:
		return("Unable to get local issuer certificate");
	case BEID_CERTSTATUS_UNABLE_TO_VERIFY_LEAF_SIGNATURE:
		return("Unable to verify the first certificate");
	case BEID_CERTSTATUS_CERT_CHAIN_TOO_LONG:
		return("Certificate chain too long");
	case BEID_CERTSTATUS_CERT_REVOKED:
		return("Certificate revoked");
	case BEID_CERTSTATUS_INVALID_CA:
		return ("Invalid CA certificate");
	case BEID_CERTSTATUS_PATH_LENGTH_EXCEEDED:
		return ("Path length constraint exceeded");
	case BEID_CERTSTATUS_INVALID_PURPOSE:
		return ("Unsupported certificate purpose");
	case BEID_CERTSTATUS_CERT_UNTRUSTED:
		return ("Certificate not trusted");
	case BEID_CERTSTATUS_CERT_REJECTED:
		return ("Certificate rejected");
	case BEID_CERTSTATUS_SUBJECT_ISSUER_MISMATCH:
		return("Subject issuer mismatch");
	case BEID_CERTSTATUS_AKID_SKID_MISMATCH:
		return("Authority and subject key identifier mismatch");
	case BEID_CERTSTATUS_AKID_ISSUER_SERIAL_MISMATCH:
		return("Authority and issuer serial number mismatch");
	case BEID_CERTSTATUS_KEYUSAGE_NO_CERTSIGN:
		return("Key usage does not include certificate signing");
	case BEID_CERTSTATUS_UNABLE_TO_GET_CRL_ISSUER:
		return("Unable to get CRL issuer certificate");
	case BEID_CERTSTATUS_UNHANDLED_CRITICAL_EXTENSION:
		return("Unhandled critical extension");

	default:
        return "Unknown status";
		}
}


void PrintCertifCheck( BEID_Certif certif )
{
    printf( " *** Certificate \"%s\" status: %d, (%s)\n", certif.certifLabel, certif.certifStatus, VerifyCertErrorString(certif.certifStatus) );
}


void PrintSignCheck( BEID_Certif_Check tCheck )
{
    static char *resultStr[] = { "System error",
                                     "Valid",
                                     "Invalid",
                                     "Valid & wrong RRN certificate",
                                     "Invalid & wrong RRN certificate"
                                    };
    static char *resultStrPol[] = { "None",
                                     "OCSP",
                                     "CRL",
                                     "Both"
                                    };


    printf( " *** Signature result: %d, (%s)\n", tCheck.signatureCheck, resultStr[tCheck.signatureCheck + 1] );
    
    printf( " *** Certificate checking used policy: %d, (%s)\n", tCheck.usedPolicy, resultStrPol[tCheck.usedPolicy] );
    for ( int i = 0; i < tCheck.certificatesLength; i++ ) PrintCertifCheck( tCheck.certificates[i] );
}


int main(int argc, char* argv[])
{
    // Alround test buffer
    BYTE buffer[4096] = {0};
    BEID_Bytes tBytes = {0};
    tBytes.length = 4096;
    tBytes.data = buffer;

    BEID_Status tStatus = {0};
    BEID_ID_Data idData = {0};
    BEID_Address adData = {0};
    BEID_Certif_Check tCheck = {0};
    BEID_VersionInfo tVersion = {0};
    BEID_Raw tRawData = {0};
    char pic_name[12];
    char filepath[28];
    int i;
    int j = -1;

    long lHandle = 0;
    tStatus = BEID_Init("", 0, 0, &lHandle);

////////////// High Level Test //////////////////////

    tStatus = BEID_GetID(&idData, &tCheck);
    if(BEID_OK == tStatus.general)
    {
        strcpy(pic_name, idData.nationalNumber);
    }
    memset(&tCheck, 0, sizeof(BEID_Certif_Check));

    // Read Picture Data
    tStatus = BEID_GetPicture(&tBytes, &tCheck);
    PrintStatus( "Get Picture", tStatus );
    if(BEID_OK == tStatus.general)
    {
        strcpy(filepath, "..\\patients\\Photos\\");
        for(i=11; i<23; i++)
        {
                  j++;
                  filepath[i] = pic_name[j];
        }
        filepath[23] = '.';
        filepath[24] = 'j';
        filepath[25] = 'p';
        filepath[26] = 'g';
        
        sprintf(filepath,"%s%s%s","..\\patients\\Photos\\",pic_name,".jpg");
        
        printf("\n%s\n", filepath);
        
        FILE *pf = fopen( filepath, "w+b");
        if(pf != NULL)
        {
            fwrite(tBytes.data, sizeof(unsigned char), tBytes.length, pf);
            fclose(pf);
        }
        
    }
    memset(&tCheck, 0, sizeof(BEID_Certif_Check));

    // Re use buffer
    memset(buffer, 0, sizeof(buffer));
    tBytes.length = 4096;

    tStatus = BEID_Exit();
	return 0;
}

