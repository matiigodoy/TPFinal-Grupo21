<?php

require_once("vendor/jpgraph-main/src/lib/jpgraph.php");
require_once("vendor/jpgraph-main/src/lib/jpgraph_line.php");
require_once("vendor/jpgraph-main/src/lib/jpgraph_bar.php");
require_once("vendor/jpgraph-main/src/lib/jpgraph_pie.php");


class GraphCreator
{
    public function createPieGraphCountry($title)
    {
        // Datos hardcodeados para prueba
        $labels = array("Argentina", "Brasil", "Chile", "Uruguay");
        $values = array(30, 40, 20, 10); // Valores arbitrarios para los segmentos

        // Crear un gráfico de tarta (pie chart)
        $graph = new PieGraph(600, 400);
        $graph->SetScale("textlin");

        $pieplot = new PiePlot($values);
        $pieplot->SetSliceColors(array('#1E90FF', '#2E8B57', '#FF6347', '#FFA500')); // Ejemplo de colores, puedes personalizarlos

        // Asignar leyendas a cada segmento del gráfico
        $pieplot->SetLegends($labels);

        $graph->Add($pieplot);
        $graph->title->Set($title);

        // Guardar el gráfico en un archivo
        $graph->Stroke("GraficoPaises.png");
    }
}