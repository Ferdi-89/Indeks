<?php
$useCases = [
    "01" => "Melihat Halaman Utama",
    "02" => "Melihat Informasi Paket",
    "03" => "Melihat Pengumuman Aktif",
    "04" => "Mengisi Formulir Pendaftaran",
    "05" => "Mengunggah Berkas Identitas",
    "06" => "Melihat Status Pendaftaran",
    "07" => "Melakukan Login",
    "08" => "Melakukan Logout",
    "09" => "Melihat Dashboard",
    "10" => "Melihat Grafik Pendaftaran",
    "11" => "Melihat Monitoring Server",
    "12" => "Melihat Monitoring Database",
    "13" => "Melihat Daftar Pendaftar",
    "14" => "Melihat Detail Pendaftar",
    "15" => "Mengubah Status Pendaftaran",
    "16" => "Menghapus Data Pendaftar",
    "17" => "Menambahkan Paket Baru",
    "18" => "Mengubah Data Paket",
    "19" => "Menghapus Data Paket",
    "20" => "Menambahkan Pengumuman",
    "21" => "Mengubah Pengumuman",
    "22" => "Menghapus Pengumuman",
    "23" => "Menambahkan Promosi",
    "24" => "Mengubah Promosi",
    "25" => "Menghapus Promosi",
    "26" => "Memperbarui Profil",
    "27" => "Memperbarui Perusahaan",
    "28" => "Menambahkan Area",
    "29" => "Mengubah Area",
    "30" => "Menghapus Area",
];

$userAssoc = ["01", "02", "03", "04"];
$adminAssoc = ["07", "08", "09", "13", "17", "18", "19", "20", "21", "22", "23", "24", "25", "26", "27", "28", "29", "30"];
$devAssoc = ["07", "08", "09", "11", "12", "26"];

$xml = '<?xml version="1.0" encoding="windows-1252"?>
<XMI xmi.version="1.1" xmlns:UML="omg.org/UML1.3">
	<XMI.header>
		<XMI.documentation>
			<XMI.exporter>Enterprise Architect</XMI.exporter>
			<XMI.exporterVersion>2.5</XMI.exporterVersion>
		</XMI.documentation>
	</XMI.header>
	<XMI.content>
		<UML:Model name="EA Model" xmi.id="MX_EAID_Model">
			<UML:Namespace.ownedElement>
				<UML:Class name="EARootClass" xmi.id="EAID_11111111_5487_4080_A7F4_41526CB0AA00" isRoot="true" isLeaf="false" isAbstract="false"/>
				<UML:Package name="Use Case Model R-NET Expanded" xmi.id="EAPK_00000000_0000_0000_0000_000000000001" isRoot="false" isLeaf="false" isAbstract="false" visibility="public">
					<UML:ModelElement.taggedValue>
						<UML:TaggedValue tag="ea_stype" value="Public"/>
					</UML:ModelElement.taggedValue>
					<UML:Namespace.ownedElement>

						<UML:Actor name="Calon Pelanggan" xmi.id="EAID_AC000000_0000_0000_0000_000000000001" visibility="public" isRoot="false" isLeaf="false" isAbstract="false">
                            <UML:ModelElement.taggedValue><UML:TaggedValue tag="ea_stype" value="Actor"/><UML:TaggedValue tag="ea_ntype" value="0"/></UML:ModelElement.taggedValue>
                        </UML:Actor>
						<UML:Actor name="Admin" xmi.id="EAID_AC000000_0000_0000_0000_000000000002" visibility="public" isRoot="false" isLeaf="false" isAbstract="false">
                            <UML:ModelElement.taggedValue><UML:TaggedValue tag="ea_stype" value="Actor"/><UML:TaggedValue tag="ea_ntype" value="0"/></UML:ModelElement.taggedValue>
                        </UML:Actor>
						<UML:Actor name="Developer" xmi.id="EAID_AC000000_0000_0000_0000_000000000003" visibility="public" isRoot="false" isLeaf="false" isAbstract="false">
                            <UML:ModelElement.taggedValue><UML:TaggedValue tag="ea_stype" value="Actor"/><UML:TaggedValue tag="ea_ntype" value="0"/></UML:ModelElement.taggedValue>
                        </UML:Actor>

						<UML:Subsystem name="Sistem Layanan Internet R-NET" xmi.id="EAID_SB000000_0000_0000_0000_000000000001" visibility="public" isRoot="false" isLeaf="false" isAbstract="false">
                            <UML:ModelElement.taggedValue><UML:TaggedValue tag="ea_stype" value="Subsystem"/><UML:TaggedValue tag="ea_ntype" value="0"/></UML:ModelElement.taggedValue>
                        </UML:Subsystem>
';

foreach($useCases as $id => $name) {
    $xml .= '
						<UML:UseCase name="'.$name.'" xmi.id="EAID_UC000000_0000_0000_0000_0000000000'.$id.'" visibility="public" isRoot="false" isLeaf="false" isAbstract="false">
                            <UML:ModelElement.taggedValue><UML:TaggedValue tag="ea_stype" value="UseCase"/><UML:TaggedValue tag="ea_ntype" value="0"/></UML:ModelElement.taggedValue>
                        </UML:UseCase>';
}

$includes = [
    ["04", "05", "include"],
    ["06", "04", "extend"],
    ["10", "09", "extend"],
    ["11", "09", "extend"],
    ["12", "09", "extend"],
    ["14", "13", "extend"],
    ["15", "13", "extend"],
    ["16", "13", "extend"],
];

$ctr = 1;
foreach($includes as $inc) {
    $xml .= '
						<UML:Dependency client="EAID_UC000000_0000_0000_0000_0000000000'.$inc[0].'" supplier="EAID_UC000000_0000_0000_0000_0000000000'.$inc[1].'" xmi.id="EAID_DP000000_0000_0000_0000_00000000000'.$ctr.'" visibility="public" isRoot="false" isLeaf="false" isAbstract="false">
							<UML:ModelElement.stereotype><UML:Stereotype name="'.$inc[2].'"/></UML:ModelElement.stereotype>
                            <UML:ModelElement.taggedValue><UML:TaggedValue tag="ea_type" value="Dependency"/><UML:TaggedValue tag="direction" value="Source -&gt; Destination"/></UML:ModelElement.taggedValue>
						</UML:Dependency>';
    $ctr++;
}

$ctr = 1;
foreach($userAssoc as $uc) {
    $xml .= '
						<UML:Association xmi.id="EAID_AS000000_0000_0000_0000_0000000000'.$ctr.'" visibility="public" isRoot="false" isLeaf="false" isAbstract="false">
                            <UML:ModelElement.taggedValue><UML:TaggedValue tag="ea_type" value="Association"/><UML:TaggedValue tag="direction" value="Source -&gt; Destination"/></UML:ModelElement.taggedValue>
							<UML:Association.connection>
                                <UML:AssociationEnd visibility="public" aggregation="none" isOrdered="false" targetScope="instance" changeable="none" isNavigable="false" type="EAID_AC000000_0000_0000_0000_000000000001"/>
                                <UML:AssociationEnd visibility="public" aggregation="none" isOrdered="false" targetScope="instance" changeable="none" isNavigable="true" type="EAID_UC000000_0000_0000_0000_0000000000'.$uc.'"/>
                            </UML:Association.connection>
						</UML:Association>';
    $ctr++;
}

foreach($adminAssoc as $uc) {
    $xml .= '
						<UML:Association xmi.id="EAID_AS000000_0000_0000_0000_0000000000'.$ctr.'" visibility="public" isRoot="false" isLeaf="false" isAbstract="false">
                            <UML:ModelElement.taggedValue><UML:TaggedValue tag="ea_type" value="Association"/><UML:TaggedValue tag="direction" value="Source -&gt; Destination"/></UML:ModelElement.taggedValue>
							<UML:Association.connection>
                                <UML:AssociationEnd visibility="public" aggregation="none" isOrdered="false" targetScope="instance" changeable="none" isNavigable="false" type="EAID_AC000000_0000_0000_0000_000000000002"/>
                                <UML:AssociationEnd visibility="public" aggregation="none" isOrdered="false" targetScope="instance" changeable="none" isNavigable="true" type="EAID_UC000000_0000_0000_0000_0000000000'.$uc.'"/>
                            </UML:Association.connection>
						</UML:Association>';
    $ctr++;
}

foreach($devAssoc as $uc) {
    $xml .= '
						<UML:Association xmi.id="EAID_AS000000_0000_0000_0000_0000000000'.$ctr.'" visibility="public" isRoot="false" isLeaf="false" isAbstract="false">
                            <UML:ModelElement.taggedValue><UML:TaggedValue tag="ea_type" value="Association"/><UML:TaggedValue tag="direction" value="Source -&gt; Destination"/></UML:ModelElement.taggedValue>
							<UML:Association.connection>
                                <UML:AssociationEnd visibility="public" aggregation="none" isOrdered="false" targetScope="instance" changeable="none" isNavigable="false" type="EAID_AC000000_0000_0000_0000_000000000003"/>
                                <UML:AssociationEnd visibility="public" aggregation="none" isOrdered="false" targetScope="instance" changeable="none" isNavigable="true" type="EAID_UC000000_0000_0000_0000_0000000000'.$uc.'"/>
                            </UML:Association.connection>
						</UML:Association>';
    $ctr++;
}

$xml .= '
					</UML:Namespace.ownedElement>
				</UML:Package>
			</UML:Namespace.ownedElement>
		</UML:Model>
	</XMI.content>
';

// Diagram Layout section
$diagramElements = '';
$diagramElements .= '<element geometry="Left=250;Top=50;Right=750;Bottom=1500;" subject="EAID_SB000000_0000_0000_0000_000000000001" seqno="1" style="DUID=B01;"/>'."\n";

$diagramElements .= '<element geometry="Left=50;Top=100;Right=95;Bottom=190;" subject="EAID_AC000000_0000_0000_0000_000000000001" seqno="2" style="DUID=A01;"/>'."\n";
$diagramElements .= '<element geometry="Left=850;Top=250;Right=895;Bottom=340;" subject="EAID_AC000000_0000_0000_0000_000000000002" seqno="3" style="DUID=A02;"/>'."\n";
$diagramElements .= '<element geometry="Left=850;Top=1100;Right=895;Bottom=1190;" subject="EAID_AC000000_0000_0000_0000_000000000003" seqno="4" style="DUID=A03;"/>'."\n";

// Coordinates for Use Cases
foreach($useCases as $id => $name) {
    $col = ((int)$id % 2 == 0) ? 550 : 300;
    $row = 50 + (((int)$id) * 45);
    $duid = "U" . $id;
    $diagramElements .= '<element geometry="Left='.$col.';Top='.$row.';Right='.($col+120).';Bottom='.($row+50).';" subject="EAID_UC000000_0000_0000_0000_0000000000'.$id.'" seqno="'.(10+(int)$id).'" style="DUID='.$duid.';"/>'."\n";
}

$xml .= '
	<XMI.extensions xmi.extender="Enterprise Architect 2.5">
        <diagrams>
            <diagram xmi.id="EAID_DIAG_0000_0000_0000_000000000001">
                <model package="EAPK_00000000_0000_0000_0000_000000000001" localID="1" owner="EAPK_00000000_0000_0000_0000_000000000001"/>
                <properties name="Use Case Diagram R-NET" type="Use Case"/>
                <project author="System" version="1.0" created="2026-05-09 00:00:00" modified="2026-05-09 00:00:00"/>
                <style1 value="ShowPrivate=1;ShowProtected=1;ShowPublic=1;HideRelationships=0;Locked=0;Border=1;HighlightForeign=1;PackageContents=1;SequenceNotes=0;ScalePrintImage=0;PPgs.cx=1;PPgs.cy=2;DocSize.cx=827;DocSize.cy=1169;ShowDetails=0;Orientation=P;Zoom=100;ShowTags=0;OpParams=1;VisibleAttributeDetail=0;ShowOpRetType=1;ShowIcons=1;CollabNums=0;HideProps=0;ShowReqs=0;ShowCons=0;PaperSize=9;HideParents=0;UseAlias=0;HideAtts=0;HideOps=0;HideStereo=0;HideElemStereo=0;ShowTests=0;ShowMaint=0;ConnectorNotation=UML 2.1;ExplicitNavigability=0;ShowShape=1;AdvancedElementProps=1;AdvancedFeatureProps=1;AdvancedConnectorProps=1;m_bElementClassifier=1;ShowNotes=0;SuppressBrackets=0;SuppConnectorLabels=0;PrintPageHeadFoot=0;ShowAsList=0;"/>
                <style2 value="SaveTag=0;"/>
                <elements>
                ' . $diagramElements . '
                </elements>
            </diagram>
        </diagrams>
    </XMI.extensions>
</XMI>
';

file_put_contents('UseCase_RNET.xml', $xml);
echo "Berhasil update UseCase_RNET.xml dengan 3 Actor dan Diagram Auto-layout!";
?>
