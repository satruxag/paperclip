# Opportunity Intelligence Configuration

## File di configurazione aziendale

Il file `opportunity-sources.json` contiene la configurazione **aziendale** della pipeline Opportunity Intelligence:
- Elenco fonti bandi e agevolazioni monitorate
- Profilo ATECO dell'azienda
- Filtri di ammissibilità alle opportunità

## ⚠️ Posizione del file

Questo file **NON deve essere committato** nel repository Paperclip (fork upstream) perché:
1. Contiene dati aziendali interni (profilo ATECO, settori di attività)
2. È configurazione specifica della nostra azienda, non del prodotto generico

### Posizione attuale (ignored)

Il file è presente in questa directory ma è esplicitamente ignorato da `.gitignore`:
```
server/config/opportunity-sources.json
```

### Backup versionato

Una copia sincronizzata è disponibile in:
```
~/ClaudeVault/Config/paperclip/opportunity-sources.json
```

Questa posizione garantisce:
- Backup automatico via Syncthing
- Versionamento storico
- Accessibilità da qualsiasi macchina sincronizzata

## Aggiornamenti

Le modifiche alla configurazione devono essere:
1. Apportate direttamente a `server/config/opportunity-sources.json`
2. Sincronizzate manualmente su `~/ClaudeVault/Config/paperclip/opportunity-sources.json`
3. Documentate nella issue GitHub corrispondente

## Pipeline di lettura

La pipeline Automazione Contenuti legge questo file dal path hardcoded:
```
/home/sartux/progetti/dodoo-paperclip/server/config/opportunity-sources.json
```

Non spostare il file senza coordinare con lo Sviluppatore Automazione Contenuti (ROS-599).
