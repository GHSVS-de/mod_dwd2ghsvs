<?php
defined('_JEXEC') or die;
JHtml::_('script', 'mod_dwd2ghsvs/leaflet.js', array('version' => 'auto', 'relative' => true));
JHtml::_('stylesheet', 'mod_dwd2ghsvs/leaflet.css', array('version' => 'auto', 'relative' => true));
JHtml::_('jquery.framework');
JHtml::_('script', 'mod_dwd2ghsvs/leaflet-betterwms.js', array('version' => 'auto', 'relative' => true));
?>
<!-- hier wird der Kartencontainer definiert, in welchem anschließend die Karte dargestellt wird -->
<div id="kartencontainer" style="width: 800px; height: 600px;"></div>

<script>
	// Leaflet-Kartenobjekt im referenzierten div erstellen und initiale Optionen für Karte übergeben
	var karte = L.map('kartencontainer', {
		// Mittelpunkt der Karte als Breiten- und Längengrad, bspw. 50.0956° N, 8.7761° E für Offenbach
		center: [50.0956, 8.7761],
		// initiales Zoomlevel
		zoom: 7, 
		// interaktivität der Karte kann mit Optionen gesteuert werden
		zoomControl: true,
		dragging: true,
		attributionControl: true
	});

	// OSM-Hintergrundslayer definieren
	var osmlayer =  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
		attribution: 'Map data: &copy; <a href="https://openstreetmap.org">OpenStreetMap</a> contributors',
		maxZoom: 18
	});

	// Warnungs-Layer vom DWD-Geoserver - betterWms fügt Möglichkeiten zur GetFeatureInfo hinzu
	var warnlayer = L.tileLayer.betterWms("https://maps.dwd.de/geoproxy_warnungen/service/", {
		layers: 'Warnungen_Gemeinden_vereinigt',
		// eigene Styled Layer Descriptor (SLD) können zur alternativen Anzeige der Warnungen genutzt werden (https://docs.geoserver.org/stable/en/user/styling/sld/reference/)
		//sld: 'https://eigenerserver/alternativer.sld',
		format: 'image/png',
		transparent: true,
		opacity: 0.8,
		attribution: 'Warndaten: &copy; <a href="https://www.dwd.de">DWD</a>'
	});

	// CQL_FILTER können benutzt werden um angezeigte Warnungen zu filtern (https://docs.geoserver.org/stable/en/user/tutorials/cql/cql_tutorial.html)
	// Filterung kann auf Basis der verschiedenen properties der Warnungen erfolgen (bspw. EC_II, EC_GROUP, DESCRIPTION ... ) siehe https://www.dwd.de/DE/wetter/warnungen_aktuell/objekt_einbindung/einbindung_karten_geowebservice.pdf
 	// warnlayer.setParams({CQL_FILTER:"DESCRIPTION LIKE '%Sturm%'"});
 	// Filter können zur Laufzeit, z.B. über Nutzereingaben angepasst werden
 	//delete warnlayer.wmsParams.CQL_FILTER;
 	//warnlayer.redraw();

 	// Layer mit neutraler Darstellung der Gemeinde-Warngebiete
	var gemeindelayer = L.tileLayer.wms("https://maps.dwd.de/geoproxy_warnungen/service/", {
		layers: 'Warngebiete_Gemeinden',
		format: 'image/png',
		styles: '',
		transparent: true,
		opacity: 0.6,
		attribution: 'Geobasisdaten Gemeinden: &copy; <a href="https://www.bkg.de">BKG</a> 2015 (Daten verändert)'
	});

	// Layerlisten für die Layercontrol erstellen und dabei initial aktive Layer zur Karte hinzufügen
	var baseLayers = {
			"OpenStreetMap": osmlayer.addTo(karte)
	};
	var overLayers = {
			"<span title='DWD Geoserver dwd:Warnungen_Gemeinden_vereinigt'>Gemeinde vereinigt</span>": warnlayer.addTo(karte),
			"<span title='DWD Geoserver Gemeindewarngebiete'>Warngebiete (Gemeinden)</span>": gemeindelayer
	};

	// Layercontrol-Element erstellen und hinzufügen
    L.control.layers(baseLayers, overLayers).addTo(karte);

	// Demo-Marker mit Popup hinzufügen
	var marker = L.marker([50.099444, 8.770833]).addTo(karte);
	marker.bindPopup("<b>Deutscher Wetterdienst</b><br>Wetter und Klima aus einer Hand").openPopup();
</script>
