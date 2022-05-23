   $(document).on("submit", "form", function(event) {
       $('#submitBtn').html('')
       $('#alert').show();
       jQuery('<div>', {
           id: 'loading',
           class: 'spinner-border text-warning',
       }).appendTo('#submitBtn');

       $('#submitBtn').prop('disabled', true)
       event.preventDefault();
       $.ajax({
           url: './actions.php',
           type: 'POST',
           dataType: "text",
           data: new FormData(this),
           processData: false,
           contentType: false,
           success: function(data, status) {
               console.log(JSON.parse(data));
               showInPageAndZipGenerate(JSON.parse(data));
           },
           error: function(xhr, desc, err) {
               console.log("Error" + err);
           }
       });
   });
   // Zip'e atılacak dosyanın verilerini al.
   const fetchData = (file) =>
       fetch(file)
       .then((res) => res.blob());

   //  Yeni bir jszip nesnesi oluştur.
   var zip = new JSZip();

   // Filigranlanan resimleri ekranda göster ve zip'e ekle
   function showInPageAndZipGenerate(data) {
       data = Array.from(data);
       let idx = 0;
       data.forEach(element => {
           // ekrana ekleme işlemi
           idx++;
           jQuery('<img>', {
               id: 'image' + idx,
               class: 'col-md-4 mt-3 mb-3 shadow  ',
               style: 'border-radius:12px;',
               src: './' + element,
           }).appendTo('#imagesContainer');
           // resmin verisini al
           const data = fetchData(element);
           // resimleri zip'e ekle
           zip.file("Hello.txt", "Merhaba Dünya\n Ben Furkan Genç \n Bana 27furkangenc@gmail.com adresinden ulaşabilirsin \n -github.com/thefurkangenc");
           var img = zip.folder("images");
           img.file(element, data, {
               base64: true
           });
           console.log(element);
       });
       zip.generateAsync({
               type: "blob"
           })
           .then(function(content) {
               saveAs(content, "result.zip");
           });
       $('#submitBtn').prop('disabled', false)
       $('#submitBtn').html('Generate');
       $('#loading').remove();
       $('#alert').hide('slow');
   }