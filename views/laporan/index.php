<?php

echo "<div class=\"easyui-layout\" style=\"width:100%;height:100%;\">\n    <div data-options=\"region:'center',border:false\" style=\"height:100%;padding: 10px\">\n        <div class=\"form-control\">\n            <input id=\"tanggal_awal\" class=\"easyui-datebox\"\n                   label=\"Interval Waktu:\" labelWidth=\"100px\"\n                   style=\"width:220px\" value=\"";
echo date("Y-m-d");
echo "\">\n            s/d\n            <input id=\"tanggal_akhir\" class=\"easyui-datebox\"\n                   style=\"width:120px\" value=\"";
echo date("Y-m-d");
echo "\">\n        </div>\n        <div class=\"form-control\">\n            Jenis Laporan :<br>\n            <input type=\"radio\" name=\"jenis\" value=\"wpp\" checked> WPP<br>\n            <input type=\"radio\" name=\"jenis\" value=\"lbb1\"> LBB1<br>\n            <input type=\"radio\" name=\"jenis\" value=\"lbb2\"> LBB2<br>\n            <input type=\"radio\" name=\"jenis\" value=\"njb_item\"> NJB per Item<br>\n            <input type=\"radio\" name=\"jenis\" value=\"njb_nota\"> NJB per Nota<br>\n            <input type=\"radio\" name=\"jenis\" value=\"nsc_item\"> NSC per Item<br>\n            <input type=\"radio\" name=\"jenis\" value=\"nsc_nota\"> NSC per Nota<br>\n            <input type=\"radio\" name=\"jenis\" value=\"part\"> Penjualan Suku Cadang<br>\n        </div>\n        <div class=\"form-control\">\n            <a id=\"btn-cetak\" href=\"#\" class=\"easyui-linkbutton\" data-options=\"iconCls:'icon-search'\">Cetak</a>\n        </div>\n    </div>\n</div>\n<script>\n    \$(\"#btn-cetak\").click(function () {\n        var url;\n        var radio = \$(\"input[name='jenis']:checked\").val();\n        if(radio == \"wpp\"){\n            url = \"";
echo yii\helpers\Url::to(array("wpp"));
echo "\";\n        }else if(radio == \"lbb1\"){\n            url = \"";
echo yii\helpers\Url::to(array("lbb1"));
echo "\";\n        }else if(radio == \"lbb2\"){\n            url = \"";
echo yii\helpers\Url::to(array("lbb2"));
echo "\";\n        }else if(radio == \"njb_item\"){\n            url = \"";
echo yii\helpers\Url::to(array("njb-item"));
echo "\";\n        }else if(radio == \"njb_nota\"){\n            url = \"";
echo yii\helpers\Url::to(array("njb-nota"));
echo "\";\n        }else if(radio == \"nsc_item\"){\n            url = \"";
echo yii\helpers\Url::to(array("nsc-item"));
echo "\";\n        }else if(radio == \"nsc_nota\"){\n            url = \"";
echo yii\helpers\Url::to(array("nsc-nota"));
echo "\";\n        }else if(radio == \"part\"){\n            url = \"";
echo yii\helpers\Url::to(array("part"));
echo "\";\n        }\n\n        window.open(url + \"?tanggal1=\"+\$(\"#tanggal_awal\").val()+\"&tanggal2=\"+\$(\"#tanggal_akhir\").val(), \"Laporan\", \"width=800,height=600\");\n\n        return false;\n    });\n\n    setTitle(\"Laporan\");\n</script>";

?>