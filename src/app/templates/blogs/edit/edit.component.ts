import { Component, OnInit } from '@angular/core';
import { ActivatedRoute, Router } from '@angular/router';
import { FormControl, FormGroup, Validators } from '@angular/forms';
import { DataService } from 'src/app/services/data/data.service';
import { MatSnackBar } from '@angular/material/snack-bar';
import { ApisService } from 'src/app/services/apis/apis.service';
import { LoaderService } from './../../../services/loader/loader.service';
import { isEmpty } from 'rxjs';
@Component({
  selector: 'app-edit',
  templateUrl: './edit.component.html',
  styleUrls: ['./edit.component.less']
})
export class EditComponent implements OnInit {
  categories: (any)[] = [];
  image64: any;
  blogImage: any;
  form = new FormGroup({
    name: new FormControl('', [Validators.required]),
    description: new FormControl('', [Validators.required]),
    category: new FormControl('', Validators.required),
    image: new FormControl()
  });
  progressBar = false;
  id: number;
  constructor(private loader: LoaderService, private router: Router, private activeRoute: ActivatedRoute, private data: DataService, private apis: ApisService, private _snackBar: MatSnackBar) {
    this.apis.getCategories();
    this.data.categories.subscribe(data => this.categories = data);
    this.loader.show.next(true);
    this.id = Number(this.activeRoute.snapshot.paramMap.get('id'))
    this.apis.getBlog(this.id).toPromise()
      .then(res => {
        var data: any = { ...res };
        if (data['status']) {
          data = data['data'];
          this.form.get('name')?.setValue(data['name'])
          this.form.get('description')?.setValue(data['description'])
          this.form.get('category')?.setValue(data['cat_id'])
          this.blogImage = data['image'];
        }
      })
      .finally(() => this.loader.show.next(false));
  }
  get name() {
    return this.form.get('name');
  }
  get description() {
    return this.form.get('description');
  }
  get category() {
    return this.form.get('category');
  }
  get image() {
    return this.form.get('image');
  }

  getImage() {
    return this.form.get('image');
  }

  ngOnInit(): void {
  }
  handleUpload(event: any) {
    const file = event.target.files[0];
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => {
      this.image64 = reader.result;
      this.blogImage = this.image64;
    };
  }
  updateBlog() {
    if (this.image64) {
      this.form.value.image = this.image64;
    }
    this.progressBar = true;
    if (this.form.valid) {
      this.apis.updateBlog(this.form.value, this.id)
        .toPromise()
        .then(res => {
          var data: any = { ...res };
          if (data['status']) {
            this._snackBar.open(`Blog Updated SUCCESSFLY`, 'Success', { duration: 2000, });
            this.router.navigate(['blogs/view/' + this.id]);
          }
        })
        .catch(error => {
          console.log('error', error);
          this._snackBar.open(`can't update blog error: ${error.error.name}`, 'Error', { duration: 5000, });
        })
        .finally(() => {
          this.progressBar = false;
        });
    } else {
      this.progressBar = false;
    }
  }
}
