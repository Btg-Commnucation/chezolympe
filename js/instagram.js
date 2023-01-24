class insagramPost {
  constructor(caption, media_type, media_url, permalink) {
    this.caption = caption;
    this.media_type = media_type;
    this.media_url = media_url;
    this.permalink = permalink;
  }

  setPostTitle() {
    const title = document.createElement("span");
    title.classList.add("screen-reader-text");
    title.innerHTML = this.caption;
    return title;
  }

  setPostImage() {
    const image = document.createElement("img");
    image.src = this.media_url;
    image.alt = this.caption;
    return image;
  }

  setPostLink() {
    const link = document.createElement("a");
    link.href = this.permalink;
    link.target = "_blank";
    link.rel = "noopener noreferrer";
    link.appendChild(this.setPostTitle());
    link.appendChild(this.setPostImage());
    return link;
  }

  setPostListItem() {
    const listItem = document.createElement("li");
    listItem.appendChild(this.setPostLink());
    return listItem;
  }
}

export const instagramPosts = (token) => {
  const url = `https://graph.instagram.com/me/media?fields=id,caption,media_type,media_url,permalink,thumbnail_url,timestamp,username&access_token=${token}`;
  const instaPostContainer = document.querySelector(".insta-image");
  let i = 0;

  fetch(url)
    .then((response) => {
      return response.json();
    })
    .then((res) => {
      for (const item of res.data) {
        if (item.media_type === "IMAGE" && i < 6) {
          const post = new insagramPost(
            item.caption,
            item.media_type,
            item.media_url,
            item.permalink
          );
          instaPostContainer.appendChild(post.setPostListItem());
          i++;
        }
      }
    });
};
