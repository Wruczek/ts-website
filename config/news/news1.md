Informacje na temat systemu newsów
Wruczek, 2016-06-24, 21:00

Jeśli chcesz, możesz dodawać, zmieniać oraz usuwać newsy w domyślnym podfolderze <code>news</code> ulokowanym w folderze <code>config</code>. Lokalizację folderu możesz zminić na dowolną w pliku konfiguracyjnym.
Aktualnie newsy są tworzone przy użyciu Markdown mieszanego z HTMLem. Może potem dodam jakiś panel, a na razie polecam [prosty poradnik na temat Markdown od GitHuba](https://guides.github.com/features/mastering-markdown/).

Przydatne informacje:
- Newsy wczytywane są z folderu w kolejności alfabetycznej
- Każdy plik z newsami musi mieć rozszerzenie .md (Markdown)
- Format plikow z newsami:
   - Pierwsza linijka: tytuł newsa
   - Druga linijka: autor i data
   - Trzecia linijka: pusta (taki seperator)
   - Reszta pliku: treść newsa (Markdown + HTML)
