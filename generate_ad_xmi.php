<?php
// Generator Activity Diagram EA 100% Valid Structure
$people = [
    'Orang1_Frontend' => [
        'UC01' => ['Melihat Halaman Utama', ['Mengakses URL Sistem', 'Memuat Halaman Utama', 'Menampilkan Antarmuka']],
        'UC02' => ['Melihat Informasi Paket', ['Navigasi ke Menu Paket', 'Sistem Mengambil Data Paket', 'Menampilkan Katalog Paket']],
        'UC03' => ['Melihat Pengumuman', ['Masuk ke Halaman Utama', 'Mengecek Pengumuman Aktif', 'Memunculkan Banner Pengumuman']],
        'UC04' => ['Mengisi Formulir Pendaftaran', ['Menekan Tombol Daftar', 'Mengisi Data Diri', 'Sistem Memvalidasi Data', 'Sistem Menyimpan Data Pendaftar']],
        'UC05' => ['Mengunggah Berkas', ['Memilih File Foto KTP', 'Sistem Mengompresi Foto', 'Menyimpan File ke S3 Storage']],
        'UC06' => ['Melihat Status Pendaftaran', ['Menunggu Proses Selesai', 'Sistem Mengirim Feedback', 'Menampilkan Popup Sukses atau Gagal']]
    ],
    'Orang2_PendaftaranAuth' => [
        'UC07' => ['Melakukan Login', ['Memasukkan Email dan Password', 'Sistem Memverifikasi Kredensial', 'Sistem Membuat Session', 'Mengarahkan ke Dashboard']],
        'UC08' => ['Melakukan Logout', ['Menekan Tombol Logout', 'Sistem Menghapus Session', 'Mengarahkan ke Halaman Login']],
        'UC13' => ['Melihat Daftar Pendaftar', ['Masuk ke Menu Pendaftar', 'Sistem Menarik Data dari DB', 'Menampilkan Tabel Pendaftar']],
        'UC14' => ['Melihat Detail Pendaftar', ['Menekan Tombol Detail', 'Sistem Memuat Data Lengkap dan Foto', 'Menampilkan Modal Detail']],
        'UC15' => ['Mengubah Status Pendaftaran', ['Memilih Status Baru', 'Sistem Memperbarui Status DB', 'Tabel Termuat Ulang Otomatis']],
        'UC16' => ['Menghapus Data Pendaftar', ['Menekan Tombol Hapus', 'Menyetujui Konfirmasi', 'Sistem Menghapus Data dan File S3']]
    ],
    'Orang3_KontenProduk' => [
        'UC17' => ['Menambahkan Paket Baru', ['Menekan Tombol Tambah Paket', 'Mengisi Form Paket Baru', 'Sistem Menyimpan Data Paket']],
        'UC18' => ['Mengubah Data Paket', ['Menekan Tombol Edit', 'Memperbarui Harga atau Nama', 'Sistem Menyimpan Perubahan DB']],
        'UC19' => ['Menghapus Data Paket', ['Menekan Tombol Hapus', 'Mengonfirmasi Tindakan', 'Sistem Menghapus Paket dari DB']],
        'UC23' => ['Menambahkan Promosi', ['Menekan Tambah Promosi', 'Mengisi Data Promosi', 'Sistem Menyimpan Promosi Aktif']],
        'UC24' => ['Mengubah Promosi', ['Menekan Edit Promosi', 'Mengubah Deskripsi Waktu', 'Sistem Menyimpan Perubahan']],
        'UC25' => ['Menghapus Promosi', ['Menekan Hapus Promosi', 'Mengonfirmasi', 'Sistem Menghapus Promosi dari DB']]
    ],
    'Orang4_MonitoringPengumuman' => [
        'UC09' => ['Melihat Dashboard', ['Navigasi ke Dasbor', 'Sistem Melakukan Agregasi', 'Menampilkan Grafik dan Metrik']],
        'UC11' => ['Melihat Monitoring Server', ['Buka Area Monitoring Server', 'Sistem Membaca PHPInfo dan RAM', 'Menampilkan Status Server']],
        'UC12' => ['Melihat Monitoring Database', ['Buka Area Monitoring DB', 'Sistem Mengecek Ukuran DB S3', 'Menampilkan Status Database']],
        'UC20' => ['Menambahkan Pengumuman', ['Menekan Buat Pengumuman', 'Mengisi Teks dan Tanggal Valid', 'Sistem Menyimpan Pengumuman']],
        'UC21' => ['Mengubah Pengumuman', ['Menekan Edit pada Pengumuman', 'Mengubah Konten Pengumuman', 'Sistem Memperbarui Teks']],
        'UC22' => ['Menghapus Pengumuman', ['Menekan Tombol Hapus', 'Mengonfirmasi Penghapusan', 'Sistem Menarik Pengumuman']]
    ]
];

function eaid() {
    return 'EAID_' . strtoupper(bin2hex(random_bytes(4)) . '_' . bin2hex(random_bytes(2)) . '_' . bin2hex(random_bytes(2)) . '_' . bin2hex(random_bytes(2)) . '_' . bin2hex(random_bytes(6)));
}

foreach($people as $person => $ucs) {
    $pkgId = eaid();
    $xml = '<?xml version="1.0" encoding="windows-1252"?>
<XMI xmi.version="1.1" xmlns:UML="omg.org/UML1.3">
	<XMI.header>
		<XMI.documentation>
			<XMI.exporter>Enterprise Architect</XMI.exporter>
			<XMI.exporterVersion>2.5</XMI.exporterVersion>
		</XMI.documentation>
	</XMI.header>
	<XMI.content>
		<UML:Model name="EA Model" xmi.id="MX_EA_Model">
			<UML:Namespace.ownedElement>
				<UML:Class name="EARootClass" xmi.id="EAID_11111111_5487_4080_A7F4_41526CB0AA00" isRoot="true" isLeaf="false" isAbstract="false"/>
				<UML:Package name="Activity Diagrams - '.$person.'" xmi.id="'.$pkgId.'" isRoot="false" isLeaf="false" isAbstract="false" visibility="public">
					<UML:ModelElement.taggedValue>
						<UML:TaggedValue tag="ea_stype" value="Public"/>
					</UML:ModelElement.taggedValue>
					<UML:Namespace.ownedElement>
';
    
    $diagramsXml = '';
    
    foreach($ucs as $ucId => $ucData) {
        $ucName = $ucData[0];
        $steps = $ucData[1];
        
        $actModelId = eaid();
        $compStateId = eaid();
        
        $xml .= '<UML:ActivityModel name="AD_'.$ucId.'_'.$ucName.'" xmi.id="'.$actModelId.'" context="'.$pkgId.'" visibility="public">
                    <UML:ModelElement.taggedValue>
                        <UML:TaggedValue tag="ea_stype" value="Activity"/>
                        <UML:TaggedValue tag="ea_ntype" value="0"/>
                    </UML:ModelElement.taggedValue>
                    <UML:StateMachine.transitions>';
        
        $nodes = [];
        $nodes[] = ['id' => eaid(), 'type' => 'Pseudostate', 'name' => 'Start', 'ea_stype' => 'StateNode', 'ea_ntype' => '100']; 
        foreach($steps as $step) {
            $nodes[] = ['id' => eaid(), 'type' => 'ActionState', 'name' => htmlspecialchars($step), 'ea_stype' => 'Action', 'ea_ntype' => '0'];
        }
        $nodes[] = ['id' => eaid(), 'type' => 'Pseudostate', 'name' => 'End', 'ea_stype' => 'StateNode', 'ea_ntype' => '101']; 
        
        // Transitions
        for($i = 0; $i < count($nodes) - 1; $i++) {
            $src = $nodes[$i]['id'];
            $dst = $nodes[$i+1]['id'];
            $transId = eaid();
            $xml .= '<UML:Transition xmi.id="'.$transId.'" source="'.$src.'" target="'.$dst.'" visibility="public">
                        <UML:ModelElement.stereotype><UML:Stereotype name="ControlFlow"/></UML:ModelElement.stereotype>
                        <UML:ModelElement.taggedValue>
                            <UML:TaggedValue tag="ea_type" value="ControlFlow"/>
                            <UML:TaggedValue tag="direction" value="Source -&gt; Destination"/>
                        </UML:ModelElement.taggedValue>
                     </UML:Transition>';
        }
        
        $xml .= '</UML:StateMachine.transitions>
                 <UML:StateMachine.top>
                    <UML:CompositeState xmi.id="'.$compStateId.'">
                        <UML:CompositeState.subvertex>';
        
        $diagElements = '';
        $top = 50;
        foreach($nodes as $idx => $n) {
            $tagType = $n['type'];
            $xml .= '<UML:'.$tagType.' name="'.$n['name'].'" xmi.id="'.$n['id'].'" visibility="public">
                        <UML:ModelElement.taggedValue>
                            <UML:TaggedValue tag="ea_stype" value="'.$n['ea_stype'].'"/>
                            <UML:TaggedValue tag="ea_ntype" value="'.$n['ea_ntype'].'"/>
                        </UML:ModelElement.taggedValue>
                     </UML:'.$tagType.'>';
            
            $h = ($n['ea_stype'] == 'StateNode') ? 20 : 40;
            $w = ($n['ea_stype'] == 'StateNode') ? 20 : 200;
            $left = 300 - ($w/2);
            $diagElements .= '<element geometry="Left='.$left.';Top='.$top.';Right='.($left+$w).';Bottom='.($top+$h).';" subject="'.$n['id'].'" seqno="'.$idx.'" style="DUID='.eaid().';"/>'."\n";
            $top += 80;
        }
        
        $xml .= '</UML:CompositeState.subvertex></UML:CompositeState></UML:StateMachine.top></UML:ActivityModel>';
        
        // Activity Diagram definition belongs to the package but links to ActivityModel
        $diagId = eaid();
        $diagramsXml .= '
            <diagram xmi.id="'.$diagId.'">
                <model package="'.$pkgId.'" localID="1" owner="'.$pkgId.'"/>
                <properties name="AD: '.$ucName.'" type="Activity"/>
                <project author="System" version="1.0" created="2026-05-09 00:00:00" modified="2026-05-09 00:00:00"/>
                <style1 value="ShowPrivate=1;ShowProtected=1;ShowPublic=1;HideRelationships=0;Locked=0;Border=1;HighlightForeign=1;PackageContents=1;SequenceNotes=0;ScalePrintImage=0;PPgs.cx=1;PPgs.cy=2;DocSize.cx=827;DocSize.cy=1169;ShowDetails=0;Orientation=P;Zoom=100;ShowTags=0;OpParams=1;VisibleAttributeDetail=0;ShowOpRetType=1;ShowIcons=1;CollabNums=0;HideProps=0;ShowReqs=0;ShowCons=0;PaperSize=9;HideParents=0;UseAlias=0;HideAtts=0;HideOps=0;HideStereo=0;HideElemStereo=0;ShowTests=0;ShowMaint=0;ConnectorNotation=UML 2.1;ExplicitNavigability=0;ShowShape=1;AdvancedElementProps=1;AdvancedFeatureProps=1;AdvancedConnectorProps=1;m_bElementClassifier=1;ShowNotes=0;SuppressBrackets=0;SuppConnectorLabels=0;PrintPageHeadFoot=0;ShowAsList=0;"/>
                <style2 value="SaveTag=0;"/>
                <elements>'.$diagElements.'</elements>
            </diagram>';
    }

    $xml .= '
					</UML:Namespace.ownedElement>
				</UML:Package>
			</UML:Namespace.ownedElement>
		</UML:Model>
	</XMI.content>
    <XMI.extensions xmi.extender="Enterprise Architect 2.5">
        <diagrams>
            '.$diagramsXml.'
        </diagrams>
    </XMI.extensions>
</XMI>';

    file_put_contents("e:/SEMESTER4/PBL/Indeks/ActivityDiagrams/AD_" . $person . ".xml", $xml);
}
echo "Berhasil Fix 4 file Activity Diagram XML";
?>
