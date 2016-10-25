About the news system
Wruczek, 2016-10-26, 21:00

You can add, change and remove news as a separate Markdown files located in `config/news` folder with extension `.md`.

I recommend following John Gruber's excellent markdown guide, found right under this text <i class="fa fa-long-arrow-down" aria-hidden="true"></i>. It's really worth reading. To view the code that makes up the guide, go to `config/news/news2.md`.

I can also recommend GitHub's ["Mastering Markdown"](https://guides.github.com/features/mastering-markdown/) guide.

**PS**: You can mix Markdown with HTML to add cool stuff like icons <i class="fa fa-smile-o" aria-hidden="true"></i> <i class="fa fa-thumbs-o-up" aria-hidden="true"></i>, or even a full YouTube player with video!



#### Informations:
- News are read from the `config/news` folder, alphabetically sorted by file name. (news A.md will be at top of the page while Z.md at the bottom)
- Every news file need to have `.md` (Markdown) extension
- News file syntax:
  - First line: News title
  - Second line: author and date
  - Third line: empty (seperator)
  - The rest of the file is Markdown code



#### Example news file:

    News system test
    Wruczek, 26-10-2016
    
    Hello **world**!
    
    I am the *news file*, you can save me in **config/news** folder with an **.md** extension to see my on the page!



*Good luck and Happy writing! -Wruczek*
