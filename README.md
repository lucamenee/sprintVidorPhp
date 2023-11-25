# sprintVidorPhp
Sito per la gestione delle iscrizioni a gare ciclistiche per le categorie dei giovanissimi dell'associazione sportiva dilettantistica Sprint Vidor la Vallata.

E' pervisto un sistema di login a vari livelli (genitori, allenatori e admin) ognuno con funzionalità e privilegi dedicati.

Nell'homepage viene visualizzata la tabella delle prossime corse. Da ogni pagina gli utenti possono disporre delle funzioni dedicategli, tramite l'abbosita toolbar. 

## Funzioni per tipo di utente
### Funzioni comuni
 - cambio password e logout;
 - visualizzare la lista delle prossime corse (data_evento <= data_odierna).
### Genitori
 - iscrivere i propri figli alle corse (se la data di iscrizione è anteriore a quella odierna).
### Allenatori
 - inserire/modicare i dati/eliminare gli atleti;
 - visualizzare l'archivio delle corse e le statistiche di partecipazione relative alla singola gara o al singolo atleta (filtrando i risultati per l'anno d'interesse);
 - visualizzare gli iscritti, non inscritti, coloro che non hanno effettuato la scelta, e gli atleti esclusi alle prossime gare;
 - poter modificare i dati citati alla riga superiore (iscrizione/disiscrione/esclusione) anche dopo data di chiusura delle iscrizioni.
 - inserimento/modifica delle gare.
### Admin
Tutte le funzioni degli allenatori, in aggiunta a:
 - gestione gli utenti (inserimento/modifica dei dati personali e dei ruoli/eliminazione), con annessa gestione dei legami genitori-atleti (anche eliminare gli altri admin, ma non se stesso);
 - eliminazione delle gare.



L'implementazione del database è descritta nella in sql/sprintVidor.sql. 
