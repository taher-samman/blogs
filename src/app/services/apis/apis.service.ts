import { LoaderService } from './../loader/loader.service';
import { Injectable } from '@angular/core';
import { HttpClient } from '@angular/common/http';
import { Router } from '@angular/router';
import { DataService } from '../data/data.service';

@Injectable({
  providedIn: 'root'
})
export class ApisService {
  private url = 'http://blogs.backend/';
  constructor(private data: DataService, private http: HttpClient, private router: Router, private loader: LoaderService) { }

  login(data: any) {
    const formData = new FormData();
    formData.append('username', data['username']);
    formData.append('password', data['password']);
    return this.http.post(this.url + 'auth/login', formData);
  }
  register(data: any) {
    const formData = new FormData();
    formData.append('username', data['username']);
    formData.append('email', data['email']);
    formData.append('password', data['password']);
    return this.http.post(this.url + 'auth/register', formData);
  }
  getCategories() {
    this.loader.show.next(true);
    this.http.get(this.url + 'site/getcategories',
      this.getHeaders()
    ).toPromise().then(res => {
      var response: any = { ...res };
      if (response['status'])
        this.data.categories.next(response['data']);
    }).finally(() => {
      this.loader.show.next(false);
    })
  }
  getBlogs(gotoblogs: Boolean = false) {
    this.loader.show.next(true);
    this.http.get(this.url + 'site/getblogs',
      this.getHeaders()
    ).toPromise().then(res => {
      this.getLikes();
      this.getComments();
      var response: any = { ...res };
      if (response['status']) {
        this.data.blogs.next(response['data']);
      }
      if (gotoblogs) {
        this.router.navigate(['blogs']);
      }
    }).finally(() => {
      this.loader.show.next(false);
    })
  }
  getPublicBlogs() {
    this.loader.show.next(true);
    this.http.get(this.url + 'site/getallblogs',
      this.getHeaders()
    ).toPromise().then(res => {
      this.getLikes();
      this.getComments();
      var response: any = { ...res };
      if (response['status']) {
        this.data.publicBlogs.next(response['data']);
      }
    }).finally(() => {
      this.loader.show.next(false);
    })
  }
  getBlog(id: number) {
    return this.http.get(this.url + 'blogs/getblog/' + id, this.getHeaders())
  }
  getToken() {
    return localStorage.getItem('_blogsToken')?.replace('"', '').replace('"', '')
  }
  addBlog(data: any) {
    console.log('Data in Apis Request', data)
    const formData = new FormData();
    formData.append('name', data['name']);
    formData.append('description', data['description']);
    formData.append('category', data['category']);
    formData.append('image', data['image']);
    return this.http.post(this.url + 'blogs/add',
      formData,
      this.getHeaders());
  }
  addComment(comment: string, id: number) {
    const formData = new FormData();
    formData.append('comment', comment);
    formData.append('id', id.toString());
    return this.http.post(this.url + 'blogs/addcomment', formData, this.getHeaders())
  }
  getComments() {
    this.http.get(this.url + 'blogs/getcomments', this.getHeaders()).toPromise()
      .then(res => {
        var response: any = { ...res };
        if (response['status']) {
          this.data.blogsComments.next(response['data']);
        }
      })
  }
  updateBlog(data: any, blogId: number) {
    console.log('Data in Apis Request Update', data)
    const formData = new FormData();
    formData.append('blog_id', blogId.toString());
    formData.append('name', data['name']);
    formData.append('description', data['description']);
    formData.append('category', data['category']);
    formData.append('image', data['image']);
    return this.http.post(this.url + 'blogs/update',
      formData,
      this.getHeaders());
  }
  getLikes() {
    // this.loader.showToolbarLoader.next(true);
    this.http.get(this.url + 'blogs/getlikes', this.getHeaders()).toPromise()
      .then(res => {
        var data: any = { ...res };
        this.data.blogsLikes.next(data);
      }).finally(() => {
        // this.loader.showToolbarLoader.next(false);
      })
  }
  deleteBlog(id: number) {
    return this.http.delete(this.url + `blogs/delete/${id}`, this.getHeaders());
  }
  getHeaders() {
    return {
      headers: {
        'Authorization': `Bearer ${this.getToken()}`
      }
    };
  }
  addLike(id: number) {
    var formData = new FormData();
    formData.append('id', id.toString());
    return this.http.post(this.url + 'blogs/addlike', formData, this.getHeaders())
  }
  removeLike(id: number) {
    var formData = new FormData();
    formData.append('id', id.toString());
    return this.http.post(this.url + 'blogs/removelike', formData, this.getHeaders())
  }
  removeImage(id: number) {
    return this.http.delete(this.url + 'blogs/removeimage/' + id, this.getHeaders())
  }
}

