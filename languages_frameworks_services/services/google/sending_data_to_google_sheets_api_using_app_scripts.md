# Sending data to Google sheets API using App Scripts

 Sending data to Google sheets API using App Scripts is useful to collect data from forms and storage on your own Google sheets.

1. Create your sheet on your Google Drive And create a column true story your data you desire to store. The column name must match with the date that you are collecting for you form.
2. Open your spreadsheet and click on `extensions` and click on `App scripts`.
3. Write the code to connect your spreadsheets with your data your collecting from you form. Example:
```javascript
   function doPost(e) {
  const lock = LockService.getScriptLock();
  lock.tryLock(10000);

  // Log incoming data to see what is being received
  Logger.log(e.parameter); // Check if the email is coming in

  try {
    const doc = SpreadsheetApp.openById('1tbukJe_3iJRSCNfBC2EV2inwjPPf6SJ_O5-HxkWCHD8'); // must be the same id of your spreadsheet, You can check your spreadsheet ID on the browse URL
    const sheet = doc.getSheetByName('emails');// here the column name must match with the column name you have in your spreadsheet

    const headers = sheet.getRange(1, 1, 1, sheet.getLastColumn()).getValues()[0];
    const nextRow = sheet.getLastRow() + 1;

    const newRow = headers.map(function(header) {
      return header === 'Date' ? new Date() : e.parameter[header];
    });

    sheet.getRange(nextRow, 1, 1, newRow.length).setValues([newRow]);

    return ContentService
      .createTextOutput(JSON.stringify({ 'result': 'success', 'row': nextRow }))
      .setMimeType(ContentService.MimeType.JSON);
  }
  catch (error) {
    Logger.log(error); 
    return ContentService
      .createTextOutput(JSON.stringify({ 'result': 'error', 'error': error }))
      .setMimeType(ContentService.MimeType.JSON);
  }
  finally {
    lock.releaseLock();
  }
}
   ```
4. On your app script click on `Deploy`, `New deployment`, provide a name for your deployment and click on `Done` and you'll be able to see you script URL.

5. On your application apply to code to get the data you want to send to your spreadsheet. Example:
```typescript
  // use the URL you copied from your app script
  const GoogleSheetScriptUrl = process.env.NEXT_PUBLIC_GOOGLE_SHEET_SCRIPT_URL;

  const handleSubmitEmail = async (event: FormEvent) => {
    event.preventDefault();
    try {
      setLoading(true);
      if (email) {
        if (emailRegex.test(email)) {
          toast("Cadastrando email...", {
            style: successToastStyle,
            position: "bottom-center",
          });
         // here data must be sent as new URLSearchParams
          const bodyEmail = new URLSearchParams({
            email: email,
          });

          if (GoogleSheetScriptUrl) {
            const response = await fetch(GoogleSheetScriptUrl, {
              method: "POST",
              headers: {
                "Content-Type": "application/x-www-form-urlencoded",
              },
              body: bodyEmail,
            });

            if (response.ok) {
              toast("Email cadastrado com sucesso!", {
                style: successToastStyle,
                position: "bottom-center",
              });
              setEmail("");
            }
          }
        } else {
          toast("Por favor, forneça um email válido!", {
            style: errorToastStyle,
            position: "bottom-center",
          });
          setEmail("");
        }
      }
    } catch (error) {
      toast(
        "Houve um erro ao cadastrar email. Por favor, tente novamente mais tarde.",
        {
          style: errorToastStyle,
          position: "bottom-center",
        }
      );
    } finally {
      setLoading(false);
    }
  };
```