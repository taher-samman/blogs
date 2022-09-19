import { ApisService } from 'src/app/services/apis/apis.service';
import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';

@Component({
  selector: 'app-view',
  templateUrl: './view.component.html',
  styleUrls: ['./view.component.less']
})
export class ViewComponent implements OnInit {
  id: any;
  name: string = '';
  description: string = '';
  cat_id: number = 0;
  cat_name: string = '';
  image: string = '';
  constructor(private route: ActivatedRoute, private apis: ApisService) {
    this.apis.getBlogs();
    var id = this.route.snapshot.paramMap.get('id');
    var blog = this.apis.blogs.find(b => b.id == id);
    this.id = id;
    this.name = blog['name'];
    this.description = blog['description'];
    this.cat_id = blog['cat_id'];
    this.cat_name = this.apis.categories.find(cat => cat.id = id).name;
    this.image = blog['image'];
  }

  ngOnInit(): void {
  }

}
