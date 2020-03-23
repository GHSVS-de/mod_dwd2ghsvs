# mod_dwd2ghsvs
DEMO-MODUL "Webmodul Warnungen" des DWD für Joomla

joomlaportal.de/joomla-3-x-allgemeine-fragen/330286-dwd-warnmodul-2-joomla-einbinden.html

https://www.dwd.de/DE/leistungen/webmodul_warnungen/webmodul_warnungen.html

Das Modul erleichtert lediglich die Integration aller nötigen Original-Basisdateien und Scripte in Joomla. Einstellungen können im Backend NICHT gemacht werden.

## Einrichten
- Modul oben unter dem Knopf "Clone or Download" als ZIP-Datei herunterladen
- ZIP-Datei in Joomla installieren
- Modul "mod_dwd2ghsvs" einrichten (Position, Titel).
- Bei Anzeige des Moduls im Frontend solltest du die Wetterkarte sehen wie auf https://www.dwd.de/DWD/warnungen/warnmodul/warnmod_index.html

## Anpassungen
- Datei modules/mod_dwd2ghsvs/tmpl/default.php kopieren nach: templates/DEINTEMPLATENAME/html/mod_dwd2ghsvs/default.php
- In dieser kopierten Datei kannst dann deine weiteren Anpassungen machen. Hierin befindet sich der Original-Code wie ihn dwd.de anbietet.
